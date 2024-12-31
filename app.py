from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_mail import Mail, Message

app = Flask(__name__)

# Database configuration
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///forms.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

# Email configuration
app.config['MAIL_SERVER'] = 'smtp.gmail.com'
app.config['MAIL_PORT'] = 587
app.config['MAIL_USE_TLS'] = True
app.config['MAIL_USERNAME'] = 'your-email@gmail.com'  # Replace with your email
app.config['MAIL_PASSWORD'] = 'your-email-password'  # Replace with your password
mail = Mail(app)

# Database Models
class FormSubmission(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(100), nullable=False)
    form_type = db.Column(db.String(50), nullable=False)
    form_data = db.Column(db.Text, nullable=False)

# Routes
@app.route('/submit_form', methods=['POST'])
def submit_form():
    data = request.json
    new_form = FormSubmission(
        username=data['username'], 
        form_type=data['form_type'], 
        form_data=data['form_data']
    )
    db.session.add(new_form)
    db.session.commit()

    notify_admin(data['username'], data['form_type'])
    return jsonify({"message": "Form submitted successfully!"}), 200

def notify_admin(username, form_type):
    admin_email = "admin-email@gmail.com"  # Replace with admin email
    subject = "New Form Submitted"
    body = f"User {username} submitted a {form_type} form. Please review it."
    msg = Message(subject, sender=app.config['MAIL_USERNAME'], recipients=[admin_email])
    msg.body = body
    mail.send(msg)

if __name__ == '__main__':
    db.create_all()
    app.run(debug=True)
