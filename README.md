🚗 iKarRental – Car Rental PHP Web Application
iKarRental is a web-based car rental service designed for both customers and administrators. Built with PHP and MySQL, it allows guests to browse available cars, registered users to book cars for specific dates, and administrators to manage the entire fleet and reservations.

📌 Project Overview
This PHP application simulates a car rental service with the following key functionalities:

Guests can view and filter available cars without logging in.

Registered Users can book available cars and view their reservation history.

Administrators can manage cars and bookings with full CRUD (Create, Read, Update, Delete) access.

✨ Features
🏠 Homepage / Car Listings
Displays all available cars.

Filter Options:

Availability between two dates.

Transmission type (Automatic / Manual).

Seating capacity.

Daily price range.

Basic car info shown: name, image, brand, type, seating, transmission, and daily rate.

Guests can browse but must log in to book.

🚘 Car Details Page
Shows full information for a selected car.

Logged-in users can book the car for a selected period.

Guests attempting to book will be redirected to the login page.

After booking:

Success Page: Displays car details, booking info, and total price.

Failure Page: Shows error if the car is unavailable, with an option to return to the homepage.

🔐 User Authentication
Registration Page:

Fields: Full Name, Email, Password.

Includes real-time validation and user feedback.

Login Page:

Fields: Email, Password.

Error messages for invalid credentials or missing data.

Logout:

Logout button available from all pages.

👤 User Profile Page
Shows a list of the user’s bookings.

Option to log out.

🛠️ Admin Panel
Separate admin login:

Default Credentials:

Email: admin@ikarrental.hu

Password: admin

Admin profile displays all user bookings.

Admin can:

Add new cars.

Edit existing car details.

Delete cars (and their associated bookings).
