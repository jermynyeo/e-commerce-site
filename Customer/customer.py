import json
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

app = Flask(__name__)
CORS(app)
app.config['CORS_HEADERS'] = 'Content-Type'
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://admin:esdproject@database-1.cxqk0bo2fppg.ap-southeast-1.rds.amazonaws.com:3306/customer'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

class Customer(db.Model):
    __tablename__ = 'customer'

    username = db.Column(db.String(50), primary_key=True)
    password = db.Column(db.String(50), nullable=False)
    companyName = db.Column(db.String(250), nullable=False)
    email = db.Column(db.String(150), nullable=False)

    def __init__(self, username, password, companyName, email):
        self.username = username
        self.password = password
        self.companyName = companyName
        self.email = email

    def json(self):
        return {"username": self.username, "password": self.password, "companyName": self.companyName, "email": self.email}



@app.route("/User/<string:username>", methods=['POST'])
def addUser(username):
    if (Customer.query.filter_by(username=username).first()):
        return jsonify({"message": "A username with '{}' already exists.".format(username)}), 400

    data = request.get_json()
    customer = Customer(username, **data)

    try:
        db.session.add(customer)
        db.session.commit()
    except:
        return jsonify({"message": "An error occurred creating the account."}), 500

    return jsonify({"success": "Account successfully created"}), 201

@app.route("/User", methods=['GET'])
def get_all():
    return jsonify({"users": [customer.json() for customer in Customer.query.all()]})

#Authenticate user method
@app.route("/AUser/<string:username>", methods=["POST"])
def find_by_username(username):
#Getting the data
    data = request.get_json()
    #gets the password with key password in json data
    inputpassword = data["password"]
    #if user exist check pass otherwise return does not exist
    user = Customer.query.filter_by(username=username).first()
    if user:
        password = Customer.query.filter_by(username=username).first().password
        if password == inputpassword:
            return jsonify({"message": "True"}), 200
        else:
            return jsonify({"message": "Password does not match"}), 404
    else:
        return jsonify({"message": "Username does not exist"}), 404

if __name__ == '__main__':
    app.run(host='0.0.0.0',port=5001, debug=True)
