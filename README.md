# emergency_waitlist

This is the Emergency Waitlist program from Group 23

To begin you will need to Create the database in postgres. This can be done by running the Setup.sql within postgres as shown below.:

![postgres setup](images/postgres_steup.png)

You will want to ensure You have copy and pasted the entire document!

You will then to navigate to the  config.php and where it says

$host = 'localhost';
$db = 'emergency_waitlist';
$user = 'postgres';
$password = 'postgres';

you will want to replace with the username and password of your postgres account!!


Then you will want to open a terminal at the folder and type the following code: php -S localhost:8000

then open a browser and open http://localhost:8000

Within Setup.sql we initalize there to be an admin with the username: admin_user and password: password.
You can use those to login to the admin site. 
From the admin Site you can update the status of a patient, add a new patient or delete a patient.
When a patient is deleted or there status is changed from waiting, the wait time of the other patients will update accordingly.

The wait time for each patient is calculated by 10*severity of injury of every person waiting in front of them.

You can also login via the patient site

1. [index.html]
2. [docs/html/admin.html] need to show the list of patients (make select * to patients table), ability to add new patients and current wait time
3. [docs/html/patient.html] need to show patient info and current wait time
