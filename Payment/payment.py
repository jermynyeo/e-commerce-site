# Create Payment Using PayPal Sample
# This sample code demonstrates how you can process a
# PayPal Account based Payment.
# API used: /v1/payments/payment


#library used: pip install paypalrestsdk

import json
import random
from flask import Flask, request, jsonify, render_template, redirect, url_for
from flask_cors import CORS, cross_origin
import paypalrestsdk as paypal
from paypalrestsdk import *
import logging

app = Flask(__name__)
CORS(app)

#CREDITS:  https://github.com/twtrubiks/PayPal_flask/blob/master/app.py

logging.basicConfig(level=logging.INFO)


paypal.configure({
  'mode': 'sandbox',
  "client_id": "AQBTgDBpU7hvDWrNb8SL69mjc2EG7hfQWLx5-GHKmXrJDbZX7SeRXOJIZRxM60NKPfG_tBxYmBO5_QJr",
  "client_secret": "EHXd3oyqzbXmQjY9pmQYLZ8HpB3KiAuZfShuI3GD42gsUMQ6NUVNIGBNl8grxnJ2PM82RDhWtirYj9OK"
})

def to_json(func):
	def wrapper(*args, **kwargs):
		get_fun = func(*args, **kwargs)
		return json.dumps(get_fun)
	return wrapper

@app.route("/itemsBought/<string:paymentId>")
def getItems(paymentId):
	try:
		# Retrieve the payment object by calling the
		# `find` method
		# on the Payment class by passing Payment ID
		payment = Payment.find(paymentId)
		itemList = payment.transactions[0].item_list.items
		output = {"item_list" : itemList}
		print("Got Payment Details for Payment[%s]" % (payment.id))
		return json.loads(json.dumps(output, default=str))

	except ResourceNotFound as error:
		# It will through ResourceNotFound exception if the payment not found
		print("Payment Not Found")
		return jsonify(error)

@app.route("/payment/<string:itemsList>", methods=["GET"])
@cross_origin(supports_credentials=True)
def payment(itemsList):    
	itemsList = json.loads(itemsList)
	itemsList =  (itemsList['items'])
	totalAmount = 0
	for items in itemsList:
		totalAmount += float(items['price'])	

	payment = Payment({
		"intent": "sale",
		
		# Payer
		# A resource representing a Payer that funds a payment
		# Payment Method as 'paypal'
		"payer": {
			"payment_method": "paypal"},

		# Redirect URLs
		"redirect_urls": {
			"return_url": "http://13.250.108.137:8000/payment/payment/execute",
			"cancel_url": "http://13.250.108.137:8000/payment/payment/execute"
			},

		# Transaction
		# A transaction defines the contract of a
		# payment - what is the payment for and who
		# is fulfilling it.
		"transactions": [{

			# ItemList
			"item_list": {
				"items": itemsList},

			# Amount
			# Let's you specify a payment amount.
			"amount": {
				"total": totalAmount,
				"currency": "SGD"},
			"description": "This is the payment transaction description."}]})

	# Create Payment and return status
	if payment.create():
		print("Payment[%s] created successfully" % (payment.id))
		# Redirect the user to given approval url
		for link in payment.links:
			# print  (link)
			if link.method == "REDIRECT":
				# Convert to str to avoid google appengine unicode issue
				# https://github.com/paypal/rest-api-sdk-python/pull/58
				approval_url = str(link.href)
				print("Redirect for approval: %s" % (approval_url))
		return redirect(approval_url)
	else:
		print("Error while creating payment:")
		print(payment.error)
		return payment.error

@app.route("/payment/execute")
def execute():
	paymentId = request.args['paymentId']
	payerId = request.args['PayerID']
	payment = paypal.Payment.find(paymentId)

	if payment.execute({"payer_id": payerId}): 
		print("Payment[%s] execute successfully" % (payment.id))
		#order ms URL
		return redirect("http://54.169.99.219/paymentSuccess.php?paymentId=%s&payerId=%s" % (paymentId, payerId))
		# return True
	else:
		print("Error while executing payment:")
		print(payment.error)
		return 'Payment execute ERROR!'
		
if __name__ == '__main__':
		#port can be any number, lower number commonly used by other services so don't use them
		app.run(host ='0.0.0.0', port=5000, debug=True)