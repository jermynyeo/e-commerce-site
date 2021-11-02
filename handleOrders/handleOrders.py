from flask import Flask, request, jsonify, redirect
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS, cross_origin
import requests

import json

app = Flask(__name__)
CORS(app)

@app.route("/productprogress/<string:username>", methods=['GET'])
@cross_origin(supports_credentials=True)
def UserProductProgress(username):
    # print(username)
    r = requests.get("http://13.250.108.137:8000/booking/productprogress/" + username)
    if r.status_code == 200:
        bookinginfo = json.loads(r.text)
        return jsonify(bookinginfo)
    else: 
        return jsonify(False)

@app.route("/vieworders/<string:bookingID>", methods=['GET'])
@cross_origin(supports_credentials=True)
def viewOrders(bookingID):
    r = requests.get("http://13.250.108.137:8000/booking/getinformation/" + bookingID)
    bookingInformation = json.loads(r.text)
    # print (bookingInformation)
    return jsonify(bookingInformation)

@app.route("/updateorders/<string:bookingID>/<string:productProgress>/<string:comments>", methods=['GET','PUT'])
@cross_origin(supports_credentials=True)
def updateOrder(bookingID, productProgress,comments):
    pp = {"productProgress": productProgress, "comments":comments}
    pp = json.loads(json.dumps(pp,default=str))
    r = requests.put("http://13.250.108.137:8000/booking/productprogress/" + bookingID, json = pp)
    if r.status_code == 200:      
        bookingInformation = json.loads(r.text)
        bookingInformation   = jsonify(bookingInformation)
        return jsonify({"msg":"true"})
    else: 
        return jsonify({"msg":"false"})

@app.route("/updateProducts/<string:bookingID>", methods=["GET"])
def getProducts(bookingID):
    products = requests.get("http://13.250.108.137:8000/booking/getproducts/" + bookingID)
    products = products.json()
    update = requests.put("http://13.250.108.137:8000/product/addproductqty", json = products)
    print (update)
    return jsonify (True)

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5044, debug=True)
