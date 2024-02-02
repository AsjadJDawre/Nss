const nodemailer = require('nodemailer');
const fs = require('fs');

// Email configuration
const senderEmail = 'projecttesting48@gmail.com';
const receiverEmail = 'dawreasjad72@gmail.com';
const subject = 'Test Email';

// Read the content of response.php
const message = fs.readFileSync('C:/xampp/htdocs/NSS/reponse_email.php', 'utf8');

// Create a transporter object
const transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: senderEmail,
    pass: 'llli cown oder zeuc', // Replace with your actual Gmail password
  },
});

// Email options
const mailOptions = {
  from: senderEmail,
  to: receiverEmail,
  subject: subject,
  html: message, // Assuming response.php contains HTML code
};

// Send the email
transporter.sendMail(mailOptions, (error, info) => {
  if (error) {
    console.error(error);
  } else {
    console.log('Email sent: ' + info.response);
  }
});
