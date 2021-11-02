from flask import Flask, request, jsonify, redirect
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS, cross_origin

import json
import pika
import requests
import os 

app = Flask(__name__)
CORS(app)

@app.route("/orderRoute", methods=['POST'])
@cross_origin(supports_credentials=True)
def routeorder():
    OrderInfo = request.get_json()
    print (OrderInfo)
    bookingcreationstatus = createOrder(OrderInfo) 
    print (bookingcreationstatus)
    if (bookingcreationstatus != False):       
        pdtupdatestatus  = updateProduct(OrderInfo)
        sendMonitoring(OrderInfo)
        return jsonify(True)
    return jsonify(False)

def createOrder(OrderInfo):
    createStatus = requests.post("http://13.250.108.137:8000/booking/newbooking", json = json.dumps(OrderInfo))
    if createStatus.status_code == 201:
        return True
    return False

def updateProduct(OrderInfo):
    updateProduct = requests.put("http://13.250.108.137:8000/product/updateproductqty", json = json.dumps(OrderInfo))
    if updateProduct.status_code == 200:
        return True
    return False


def sendMonitoring(OrderInfo):
    #========= Monitoring Info =========#
    prods = ", ".join(str(x) for x in OrderInfo['products'])
    OrderInfo['Sender'] = 'OrderComposite'
    OrderInfo['Receipient'] = 'Monitoring'
    OrderInfo['Message'] = ">> Successfully created booking for " + OrderInfo['username'] + "\n>> Successfully updated product quantity for PIDS: (" + prods + ")"
    #========= SENDING TO PRODUCT =========#
    
    hostname = "18.138.255.13"
    port = 5672 
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()
    exchangename="order_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')
    channel.queue_declare(queue='monitoring')
    channel.queue_bind(exchange=exchangename, queue='monitoring', routing_key='monitoring')
    replymessage = json.dumps(OrderInfo , default=str)
    channel.basic_publish(exchange=exchangename,
                          routing_key='monitoring',
                          body=replymessage)
    return "sent"

@app.route("/sendnoti/<string:purpose>/<string:email>/<int:bookingID>", methods=["GET"])
def sendNotification(purpose, email, bookingID):
    # print("YES")
    if (purpose == 'fail'):
        data = {"from": "B.Y Solutions <postmaster@sandbox2257105e012e438cab8c6547d9de3687.mailgun.org>",
			  "to": [email],
			  "subject": "Payment Failure",
			  "text": "Dear Valued Customer, \n\nYour payment is unsuccessful. \nWe apologize for this unfortunate situation. Please make your payment again in our webpage. \n\n\n\n\n\n\nYours Sincerely, \nB.Y Solutions"}
    elif (purpose == 'pass'):
        data = {"from": "B.Y Solutions <postmaster@sandbox2257105e012e438cab8c6547d9de3687.mailgun.org>",
			  "to": [email],
			  "subject": "Booking ID: " +  str(bookingID) + " Congratulations! Your booking has been successfully made.",
			  "text": "Dear Valued Customer, \n\nYour payment was successful and payment has been confirmed. \nOur product manager will contact you within the next 3 working days. \nThank you for your trust in B.Y Solutions \n\n\n\n\n\n\nYours Sincerely, \nB.Y Solutions"}
    elif (purpose == 'updated'):
        data = {"from": "B.Y Solutions <postmaster@sandbox2257105e012e438cab8c6547d9de3687.mailgun.org>",
			  "to": [email],
			  "subject": "Booking ID: " +  str(bookingID) + " Congratulations! Your booking has been updated.",
			  "text": "Dear Valued Customer, \n\nYour project has been updated with further details regarding it's progress. \nOur product manager has left information regarding in depth details of your project. \nThank you for your trust in B.Y Solutions \n\n\n\n\n\n\nYours Sincerely, \nB.Y Solutions"}

    hostname = "18.138.255.13"
    port = 5672
    # broker on port 5672
    connection = pika.BlockingConnection(
        pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()
    exchangename = "order_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')
    data = json.dumps(data, default=str)
    
    channel.queue_declare(queue='notification', durable=True)
    channel.queue_bind(queue='notification', exchange=exchangename,
                       routing_key='notification.send')

    #========= SENDING TO NOTIFICATIONS =========#
    channel.basic_publish(exchange=exchangename, routing_key='notification.send', body=data,
                           properties=pika.BasicProperties(delivery_mode=2, # persisent msg 
                                                   )
                          )
    connection.close()

    return "YES"

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5005, debug=True)

