# Dallas Family Clinic

Dallas Family Clinic is a clinic management system that allows administrators and doctors to manage patient information, appointments, and other clinic-related aspects.

## Project Structure

- **Folders**:
    - `/credentials`: 
        - `credentials.txt`: Credentials for the different users.

    - `/css`: 
        - `dashboard.css`: Styles for the dashboard layout.
        - `login.css`: Styles for the login layout.
        - `styles.css`: Styles for the whole project.

    - `/database`: 
        - `clinic_db.sql`: Script to create and populate the database.

    - `/js`: 
        - `scripts.js`: JavaScript functions for handling interactions.

-----------------------------------------------------------------------
- **PHP Files**:
    - `add_bed.php`: Manages the form submission for new beds.
    - `add_doctor.php`: Manages the form submission for adding new doctors.
    - `add_medicine.php`: Manages the form submission for adding new medicines.
    - `add_patient.php`: Manages the form submission for adding new patients.
    - `appointments.php`: Manages and views appointments.
    - `config.php`: Contains connection information and related parameters.
    - `create_appointment.php`: Specifies how new appointments are created.
    - `dashboard_admin.php`: Main page for admin users with links to management sections.
    - `dashboard_doctor.php`: Main page for doctors with links to specific functionalities.
    - `delete_appointment.php`: Manages the deletion of appointments.
    - `delete_bed.php`: Manages the deletion of bed records.
    - `delete_medicine.php`: Manages the deletion of expired or outdated medicines.
    - `doctors_view_appointments.php`: Allows doctors to see their appointments.
    - `edit_doctor.php`: Edits doctor details.
    - `edit_medicine.php`: Edits medicine records.
    - `generate_reports.php`: Prepares and compiles reports for the clinic.
    - `index.php`: The landing page of the website.
    - `insert_users.php`: Manages the input of new user records.
    - `login.php`: Manages user login.
    - `logout.php`: Logs out the current user and ends the session.
    - `manage_beds.php`: Manages bed records.
    - `manage_clinic.php`: Manages clinic data.
    - `order_medicine.php`: Enables patients to order medicines prescribed by doctors.
    - `print_medicine_order.php`: Prints a medicine order.
    - `session_check.php`: Checks for an active user session.
    - `unauthorized.php`: Shows a message for unauthorized access.
    - `update_availability.php`: Updates the availability of doctors and medicines.
    - `update_bed.php`: Updates bed details.
    - `view_appointments.php`: Allows admin to view all appointments.
    - `view_doctors.php`: Shows all doctors.
    - `view_medicine_orders.php`: Lists all medicine orders.
    - `view_medicines.php`: Lists all medicines.
    - `view_patients.php`: Displays all patients.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/atilaspo/dallas-family-clinic.git
   cd dallas-family-clinic

## Set up the database

1. Create a database on your SQL server.
2. Import the files from the `database` folder into your database.

## Configure database credentials

1. Edit the `config.php` file with your database credentials.

## Run the server

1. Use a local server like XAMPP or WAMP to run the project.

## Usage

1. Navigate to `http://localhost/dallas-family-clinic` in your web browser.
2. Log in as an administrator or doctor to access the system's functionalities.

## Contribution

If you would like to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/new-feature`).
3. Make your changes and commit them (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature/new-feature`).
5. Open a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact

- **Author:** Santiago Ortiz
- **Email:** ortizsantiagopablo@gmail.com
- **GitHub:** [atilaspo](https://github.com/atilaspo)
