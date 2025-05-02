# Web-Project-

**iKarRental – PHP - website**

One of your friends contacts you with the idea of opening a car rental service. Knowing that you are studying computer programming, they ask you to create the website for the business. The following document outlines the rental service's specifications. There’s just one problem: they want to launch the business at the beginning of the next year, and they absolutely need your help!

**Basic Features**
In this assignment, you are tasked with creating a PHP application where users can view cars uploaded by an administrator without logging in. Logged-in users can book these cars for specific time periods.

Browsing Cars: Guest users can browse the available cars listed on the homepage. They can filter cars by various criteria, including available time periods and specific attributes.
User Authentication: Users can register, log in, and access their bookings on a profile page.
Booking Cars: Logged-in users can book available cars for specific time intervals.
Administrator Access: The administrator can add new cars, edit existing ones, and delete them.


**Page Functions**
Homepage / Listing Page
The homepage should display a list of all available cars.
Users should be able to filter cars on the homepage by key attributes, such as:
Availability within a specific time range (showing cars free between two dates).
Transmission type (Automatic/Manual).
Number of passengers (showing cars with seating capacity greater than the specified number).
Daily price (showing cars with a daily price within a specified range).
Car name, image, and basic attributes (brand, type, passengers, transmission, daily price) should be displayed.
Guest users can see the cars but need to register and log in to book.

**Car Details Page**
Clicking on a car from the homepage should display the car’s detailed page, which includes all its attributes.
Logged-in users can book the car for a specific period. Guest users trying to book a car should be redirected to the login page or see an error message.
Clicking the "Book" button should navigate to a new page, notifying the user of the booking’s success or failure.
Success: Displays the car’s basic information, an image, the booking details, and the total price of the booking (number of days * daily price).
Failure: If the car is already booked for the selected period, a failure message should be displayed, along with a button to return to the homepage.


**Authentication Pages**
  **Registration Form**
  Required Fields:
    Full Name
    Email Address
    Password
  Error Handling:
    Validation warnings for invalid email addresses, weak passwords, or missing fields.
    Real-time feedback to improve user experience.
  **Login Page**
    Required Fields:
      Email Address
      Password Error Handling:
      Alerts for incorrect credentials or empty fields.

**Logout Functionality**

A logout button should be available:
Clearly displayed on the profile page.
Accessible from any other page in the system.
Profile page for logged in users
The profile page is accessible to logged-in users and includes the following:

Reservation List: Displays the user's previous reservations.
Logout Functionality: A clear button for logging out.


**Admin Functions**
Separate login functionality for the administrator (default admin credentials: email: admin@ikarrental.hu, password: admin).
On the administrator's "Profile" page, all bookings should be displayed.
The administrator can:
Add new cars.
Edit existing cars, including deleting related bookings.
Delete cars.
