create database hostelmanagment;
use hostelmanagment;
-- create table stud_login(
--     roll_no int primary key ,
--     pass_word varchar(25)
-- );
-- create table staff_login(
--     staff_id varchar(25) primary key,
--     pass_word varchar(25)
-- );

create table login_auth(
    user_id int(10) primary key,
    pass_word varchar(25),
    who_is varchar(20)
)

create table stud_gate_pass(
    name varchar(30),
    roll_no int primary key ,
    department varchar(10),
    year int,
    address varchar(25),
    phone_no bigint(10),
    time_out datetime,
    time_in datetime
);
create table stud_details(
    name varchar(30),
    roll_no int primary key ,
    department varchar(25),
    year_of_study int,
    tutor_name varchar(50),
    ac_name varchar(50),
);
create table stud_personal_details(
    name varchar(30),
    roll_no int primary key,
    email varchar(40),
    date_of_birth date,
    phone_no bigint(10),
    room_no int,
    blood_group varchar(10),
    stud_address varchar(150),
    pincode int,
    department varchar(255)
);
create table stud_gurdian_details(
    name varchar(30),
    roll_no int primary key ,
    father_name varchar(50),
    mother_name varchar(50),
    father_contact_no bigint(10),
    mother_contact_no bigint(10),
    gurdian_name varchar(50),
    gurdian_contact_no bigint(10)
);

create table token_system(
    roll_no int primary key ,
    tuesday_token_count int,
    tuesday_date date,
    wednesday_token_count int,
     wednesday_date date,
    thursday_token_count int,
    thursday_date date,
    sunday_token_count int,
    sunday_date date,
    token_booked int
);

create table token_system_backup(
    roll_no int primary key ,
    tuesday_token_count int,
    tuesday_date date,
    wednesday_token_count int,
     wednesday_date date,
    thursday_token_count int,
    thursday_date date,
    sunday_token_count int,
    sunday_date date,
    token_booked int
);




create table staff_details(
    name varchar(30),
    staff_id int primary key,
    department varchar(25),
    phone_no bigint(10),
    email varchar(35)
);

create table accom_pending_request(
     staff_id varchar(25) primary key,
    staff_name varchar(30),
    accom_check_in_date date,
    accom_check_out_date date,
    no_of_male_student int,
    no_of_female_student int,
    no_of_male_staff int,
    no_of_female_staff int,
     no_of_male_student_room int,
    no_of_female_student_room int,
    no_of_male_staff_room int,
    no_of_female_staff_room int,
    pdf_name varchar(100),
    feed_back varchar(100)
);

create table accom_request(
    staff_id varchar(25) primary key,
    staff_name varchar(30),
    accom_check_in_date date,
    accom_check_out_date date,
    no_of_male_student int,
    no_of_female_student int,
    no_of_male_staff int,
    no_of_female_staff int,
    no_of_male_student_room int,
    no_of_female_student_room int,
    no_of_male_staff_room int,
    no_of_female_staff_room int,
    room_type varchar(100),
    pdf_name varchar(50),
    feed_back varchar(100)
);

create table accom_declined_request(
    staff_id varchar(25) primary key,
    staff_name varchar(30),
    accom_check_in_date date,
    accom_check_out_date date,
    no_of_male_student int,
    no_of_female_student int,
    no_of_male_staff int,
    no_of_female_staff int,
     no_of_male_student_room int,
    no_of_female_student_room int,
    no_of_male_staff_room int,
    no_of_female_staff_room int,
    pdf_name varchar(100),
    feed_back varchar(100)
);

create table staff_session (
    staff_id varchar(25) primary key,
        sur_name varchar(25),
    staff_session_id varchar(), 
    login_ip varchar(15),
    last_login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sur_name varchar(25)
);

create table student_session (
    student_rollno varchar(25) primary key,
    sur_name varchar(25),
    student_session_id varchar(), 
    login_ip varchar(15),
    last_login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
);

create table common_complaint( 
    roll_no int primary key,
    department varchar(10),
    date_of_complaint date,
    complaint_summary varchar(200),
    image_path varchar(100),
    complaint_satisfied int
);

create table individual_complaint( 
    stud_name varchar(30),
    room_no int,
    roll_no int primary key,
    date_of_complaint TIMESTAMP,
    department varchar(10),
    complaint_summary varchar(200),
    image_path  varchar(100),
    complaint_satisfied int
);

create table bus_pass(
    stud_name varchar(30),
    roll_no int primary key,
    destination varchar(30),
    leave_date date,
    booked int
);

create table gate_pass(
    stud_name varchar(30),
    roll_no int primary key ,
    department varchar(20),
    time_of_leave TIMESTAMP,
    time_of_entry TIMESTAMP,
    address_name varchar(30),
    already_booked int,
    allowed_or_not int
);

create table working_days_pass(
    stud_name varchar(30),
    roll_no int primary key,
    department varchar(20),
    tutor_name varchar(30),
    ac_name varchar(30),
    time_of_leave TIMESTAMP,
    time_of_entry TIMESTAMP,
     address_name varchar(30),
    already_booked int,
    allowed_or_not int
);

create table general_home_pass(
     stud_name varchar(30),
    roll_no int primary key,
    department varchar(20),
    time_of_leave TIMESTAMP,
    time_of_entry TIMESTAMP,
    address_name varchar(50),
     already_booked int,
     allowed_or_not int
);

create table pass_extension(
    stud_name varchar(30),
    roll_no int primary key,
    department varchar(20),
    no_of_days int,
    from_date date,
    to_date date,
    reason varchar(100),
    already_booked int
);

create table event_food(
    staff_id varchar(25) primary key,
    food_date date,
    food_event varchar(50),
    food_combo varchar(20),
    cost int,
    quantity int,
    feed_back varchar(100)
);

