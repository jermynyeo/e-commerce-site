#!/usr/bin/env python3
# The above shebang (#!) operator tells Unix-like environments
# to run this file as a python3 script

import json
import pika
import os 

def receiveOrderLog():
    hostname = "18.138.255.13"
    port = 5672 
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    exchangename="order_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')
    channel.queue_declare(queue='monitoring')
    channel.queue_bind(exchange=exchangename, queue='monitoring', routing_key='#') 
    channel.basic_qos(prefetch_count=1)
    channel.basic_consume(queue='monitoring', on_message_callback=callback, auto_ack=True)
    channel.start_consuming()     

def callback(channel, method, properties, body):
    processOrderLog(json.loads(body))
    
def processOrderLog(order):
    if 'from' not in order: 
        prods = ", ".join(str(x) for x in order['products'])
        print("NEW BOOKING MADE")
        print("From:", order['Sender'])
        print("To:", order['Receipient'])
        print(order['Message'])
        print ("Products: " + prods)
        print ("Comments: " + order['comments'])
        print ("Project Start Date: " + order['projStartDate'])

    else:
        print("NOTIFICATION SENT")
        for x in order:
            if x != "bookingID":
                txt = order[x]
                if "\n" in txt:
                    txt = txt.replace("\n", "")
                print(x, ":", txt)
        
    print()
 

if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
    print("This is " + os.path.basename(__file__) + ": receiving message logs...")
    print()
    receiveOrderLog()