import json
import requests
import pika
import os

# AMQP


def sendNotification(data):
    # { "email" : xxx , "data": [{"from": "B.Y. Solutions <postmaster@sandbox2257105e012e438cab8c6547d9de3687.mailgun.org>",
    # 		  "to": [emailAddr],
    # 		  "subject": "Booking ID: " + bookingID + " Congratulations! Your booking has been successfully made.",
    # 		  "text": "Dear Valued Customer, \n\nThank you for your support for B.Y. Solutions. \nWe hope that you had a great experience working the B.Y. Solutions. \nThank you for your trust in B.Y. Solutions and we hope to serve you again.\n\n\n\n\n\n\nYours Sincerely, \nB.Y. Solutions"}]}
    # emailAddr = body["email"]
    for x in data:
        if x != "bookingID":
            txt = data[x]
            if "\n" in txt:
                txt = txt.replace("\n", "")
            print(x, ":", txt)
    response = requests.post(
        "https://api.mailgun.net/v3/sandbox2257105e012e438cab8c6547d9de3687.mailgun.org/messages",
        auth=("api", "8fb03ff2e224ee6b7dc703ae1a448d65-ed4dc7c4-6a367438"),
        data=data)
    if (response.status_code == 200):
        return "Successfully Sent", response.status_code
    return "Sending Failed", response.status_code


def sendCreationNotification():
    hostname = "18.138.255.13" 
    port = 5672  
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(
        pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename = "order_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    # prepare a queue for receiving messages
    queue_name = "notification"
    # 'durable' makes the queue survive broker restarts
    channel.queue_declare(queue=queue_name, durable=True)
    # bind the queue to the exchange via the key
    channel.queue_bind(exchange=exchangename, queue=queue_name,
                       routing_key='notification.#')
    channel.basic_qos(prefetch_count=1)
    # set up a consumer and start to wait for coming messages
    channel.basic_consume(
        queue=queue_name, on_message_callback=callback, auto_ack=True)
    # an implicit loop waiting to receive messages; it doesn't exit by default. Use Ctrl+C in the command window to terminate it.
    channel.start_consuming()


# required signature for the callback; no return
def callback(channel, method, properties, body):
    if 'bookingID' in json.loads(body):
    	bookingID = str(json.loads(body)['bookingID'])
    	print("RECEIVED EMAILTEXT FOR BOOKINGID: " + bookingID)
    else:
        print("RECEIVED")
    result = sendNotification(json.loads(body))
    print()  # print a new line feed


# execute this program only if it is run as a script (not by 'import')
if __name__ == "__main__":
    print("This is " + os.path.basename(__file__) + ": receiving notifications...")
    print()
    sendCreationNotification()
