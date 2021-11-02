# /myapp/__init__.py
from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin
from flask_sqlalchemy import SQLAlchemy

import json
import requests

############ Call Flask, Connect Flask to Database ############
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://admin:esdproject@database-1.cxqk0bo2fppg.ap-southeast-1.rds.amazonaws.com:3306/product'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
############ Attach Flask app to database / Enable Cross Origin Resource Sharing with Flask app ############
db = SQLAlchemy(app)
CORS(app)

############ Product Class Creation ############
class Product(db.Model):
	__tablename__ = 'product'
 
	productid = db.Column(db.Integer, nullable=False)
	productcat = db.Column(db.String, primary_key=True, nullable=False)
	productsubcat = db.Column(db.String, primary_key=True, nullable=False)
	productname = db.Column(db.String, primary_key=True, nullable=False)
	quantity = db.Column(db.Integer, nullable=False)
	price = db.Column(db.Float(precision=2))

	def __init__(self, productid, productcat, productsubcat, productname, quantity, price):
		self.productid = productid
		self.productcat = productcat
		self.productsubcat = productsubcat
		self.productname = productname
		self.quantity = quantity
		self.price = price

	def json(self):
		return {"productid": self.productid, "productcat": self.productcat, "productsubcat": self.productsubcat, "productname": self.productname, "quantity": self.quantity, "price":self.price}

	def reduceQty(self):
		self.quantity -= 1
		return True

	def addQty(self):
		self.quantity += 1
		return True

@app.route("/product")
def get_all_products():
	return jsonify({"product":[product.json() for product in Product.query.all()]})

@app.route("/product/<string:productcat>")
@cross_origin(supports_credentials=True)
def get_available_products(productcat):
	product_list = list()
	for product in Product.query.filter_by(productcat=productcat):
		product_list.append(product)
	return jsonify({"products":[product.json() for product in product_list]})

@app.route("/updateProductQty", methods=["PUT"])
def minusProductQty ():
	data = request.get_json()
	data = json.loads(data)	
	product_list = data['products']
	for pid in product_list:
		pdt = Product.query.filter_by(productid = pid).first()
		pdt.reduceQty()
	db.session.commit()
	return jsonify({"message":"true"})

@app.route("/addProductQty", methods=["GET", "PUT"])
def addProductQty ():
	data = request.get_json()
	print (data)
	print (type(data))
	product_list = data['products']
	for pid in product_list:
		pdt = Product.query.filter_by(productid = pid).first()
		pdt.addQty()
	db.session.commit()
	return jsonify({"message":"true"})

if __name__=='__main__':
	app.run(host="0.0.0.0", port=5150, debug=True)
