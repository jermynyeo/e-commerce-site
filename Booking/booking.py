from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin
from flask_sqlalchemy import SQLAlchemy
import json


# ==================================== CONNECTION SPECIFICATION ====================================== #

############ Call Flask, Connect Flask to Database ############
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://admin:esdproject@database-1.cxqk0bo2fppg.ap-southeast-1.rds.amazonaws.com:3306/booking'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

############ Attach Flask app to database / Enable Cross Origin Resource Sharing with Flask app ############
db = SQLAlchemy(app)
CORS(app)

# ===================================== CLASS / DB SPECIFICATION ====================================== #

######### Booking Class Object Creation #########
class Booking(db.Model):
    __tablename__ = 'booking'

    bookingID = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(50), nullable=False)
    comments = db.Column(db.Text, nullable=True)
    productProgress = db.Column(db.Float(precision=2), nullable=True)
    projStartDate = db.Column(db.Date, nullable=True)
    projEndDate = db.Column(db.Date, nullable=True)

    def __init__(self, bookingID, username, comments, productProgress, projStartDate, projEndDate):
        self.bookingID = bookingID
        self.username = username
        self.comments = comments
        self.productProgress = productProgress
        self.projStartDate = projStartDate
        self.projEndDate = projEndDate

    def json(self):
        booking_entry = {
            "bookingID": self.bookingID,
            "username": self.username,
            "comments": self.comments,
            "productProgress": self.productProgress,
            "projStartDate": self.projStartDate,
            "projEndDate": self.projEndDate
        }
        return booking_entry

    def set_productProgress(self, update):
        self.productProgress = update
        return True

    def set_comments(self, update):
        self.comments = update
        return True

############ Booking Product Class Object Creation ############


class BookingProduct(db.Model):
    __tablename__ = 'bookingproducts'

    bookingID = db.Column(db.Integer, db.ForeignKey(
        'booking.bookingID'), primary_key=True)
    productID = db.Column(db.Integer, primary_key=True)

    def __init__(self, bookingID, productID):
        self.bookingID = bookingID
        self.productID = productID

    def json(self):
        bookingProduct = {
            "bookingID": self.bookingID,
            "productID": self.productID,
        }
        return bookingProduct


# =============================== SCENARIO 2: CUSTOMER MAKES BOOKING ================================== #
@app.route("/productprogress/<string:username>", methods=['GET'])
@cross_origin(supports_credentials=True)
def UserProductProgress(username):
    # print(username)
    bookingsProgress = Booking.query.filter_by(username=username).all()
    if bookingsProgress:
        return jsonify({"UserBookings":[booking.json() for booking in Booking.query.filter_by(username=username).all() ]}), 200
    else: 
        return jsonify(False), 404



########################   Create Booking   ########################
@app.route("/newbooking", methods=["POST"])
@cross_origin(supports_credentials=True)
def addBooking():
    lastBooking = Booking.query.order_by(Booking.bookingID.desc()).first()
    if (lastBooking == None ) : 
        newBID = 1
    else: 
        newBID = lastBooking.bookingID + 1

    data = request.get_json()
    data = json.loads(data)
    booking = Booking(newBID, data["username"], data["comments"], data["productProgress"], data["projStartDate"], data["projEndDate"])
    products = data['products']
    db.session.add(booking)
    db.session.commit()
    for p in products:
        pdt = BookingProduct(newBID, p)
        db.session.add(pdt)
    db.session.commit()
    if (Booking.query.get(newBID)):
        return jsonify({"status": "Successful Creation", "bookingID" : newBID} ), 201
    return jsonify({"status": "Failed Creation"} ), 400

@app.route("/productprogress/<string:bookingID>", methods=['PUT'])
@cross_origin(supports_credentials=True)
def updateProductProgress(bookingID):
    uProductProgress = request.json.get('productProgress')
    comments = request.json.get('comments')
    uProductProgress = float(uProductProgress)
    order = Booking.query.get(bookingID)
    order.set_productProgress(uProductProgress)
    order.set_comments(comments)
    db.session.add(order)
    db.session.commit()
    order = order.json()
    return jsonify(order), 200

@app.route("/getinformation/<string:bookingID>", methods=['GET'])
@cross_origin(supports_credentials=True)
def getInformation(bookingID):
    order = Booking.query.get(bookingID)
    order = order.json()
    return jsonify(order)

@app.route("/getProducts/<string:bookingID>", methods=["GET"])
@cross_origin(supports_credentials=True)
def getProducts(bookingID):
    products = []
    pdts = BookingProduct.query.filter_by(bookingID=bookingID)
    for pdt in pdts:
        products.append(pdt.productID)
    return jsonify({"products": products})


if __name__=='__main__':
    app.run(host='0.0.0.0',port=5250, debug=True)
