# G8T7 - B.Y Solutions

We have separated our UI interface, HTTP Microservices and AMQP Microservices into different 
AWS instances to reduce the CPU utilization of an instance, reducing latency when using our services. 
Our database has also been shifted to the cloud using Amazon RDS. 

**************************HTML****************************************

--------IMPORTANT--------------------------
We are using a sandbox account for our notification API, Mailgun. Hence, only approved accounts can receive emails.
Do take note to enable your email to receive mailgun notifications (See MAILGUN API TO RECEIVE NOTIFCATIONS below).
Also, use that approved email address to register for your customer account in our application. 
The PAYPAL Sandbox account credentials is provided below for your usage when making payment.

--------MAILGUN API TO RECEIVE NOTIFICATIONS--------------------------
Email: jermynyeo.2018@sis.smu.edu.sg
Password: esdG8T7!!!
Steps:
1) Go to mailgun.com and login using the above credentials.
2) Navigate to the left and under the Dashboard, click “Sending” > “Overview”
3) At the right side of the page, under the “Authorized Recipients” section, input your actual email and click “Save Recipient”.
4) A confirmation email will be sent to you and you will have to click “I Agree”.
5) Use this email account added to Authorized Recipients to register for your account in our application, B.Y Solutions     
6) To check our KONG api gateways and routes

--------PAYPAL API--------------------------
PayPal Sandbox Account ( to login for payment )
Email: teachingteam@esd.com.sg
Password: esdG8T7!

------------------ APPLICATION -------------------------
To load our application for customers, head down to http://54.169.99.219/
The admin/consultant console is available at http://54.169.99.219/admin.html

Admin Account ( to login in the admin page )
Username: admin
Password: password

**************************KONG****************************************

--------IP ADDRESS-------------------------
KONG IP:http://13.250.108.137:1337

--------ACCOUNT----------------------------
Username: admin
Password: password

-----------------MICROSERVICE : PORTS------------------------------
booking : 5250
customer : 5001
handleOrders : 5044
payment : 5000
product : 5150

**************************AMQP****************************************
To check our AMQP monitoring you will need an ubuntu terminal
Using the G2T4_production key you can ssh into the instance and monitor the AMQP logs

--------IP ADDRESS------------------------
AMQP IP: 18.138.255.13

--------INSTRUCTIONS TO SSH--------------
Copy the .pem file to your desktop and migrate it to your linux server. 
Use the linux server to SSH into our production server hosting rabbitMQ and AMQP microservices.
Ensure the key is chmod 400 with
chmod 400 G2T4_production.pem
ssh -i "G2T4_production.pem" ec2-user@ec2-18-138-255-13.ap-southeast-1.compute.amazonaws.com

--------DOCKER CODES TO SEE AMQP LOGS----
Monitoring
sudo docker logs -f 1f57a1ad72c9

Notification (Email)
sudo docker logs -f 27b0667d9548

Placeorders
sudo docker logs -f c57f0dbec61b

------------MICROSERVICES : PORT --------------
monitoring : -
notification : -
placeOrders : 5005

--------------- TROUBLESHOOT -------------------------
If there are any errors loading the microservices, do restart the service and input this command: 
sudo su
service rabbitmq-server restart