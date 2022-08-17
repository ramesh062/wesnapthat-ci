<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
| CUSTOM Constants
*/
//http://192.168.2.110/work/doctor_booking_system/admin

//define('BASE_URL', 'http://unusedbrain.com/doctor_booking/');
define('BASE_URL', 'http://localhost/doctor_booking/mondoc_web/');

define("ROOT_DIR", __DIR__ . "/");
define("SITE_NAME", "---------------------");
define('SITE_JS', BASE_URL.'assets/js/');
define('SITE_CSS', BASE_URL.'assets/css/');
define('SITE_IMAGES', BASE_URL.'assets/images/');
define('SITE_CALENDAR', BASE_URL .'assets/calendar/');

define('DOCTOR_PIC', FCPATH.'uploads/doctors_profile_images/');
define('DOCTOR_PIC_URL', BASE_URL.'uploads/doctors_profile_images/');

define('PATIENT_PIC', FCPATH.'uploads/patients_profile_images/');
define('PATIENT_PIC_URL', BASE_URL.'uploads/patients_profile_images/');

define('PRESCRIPTION_URL', BASE_URL.'uploads/prescription_attachments/');

define('ONE_SIGNAL_APP_ID', "5630ec08-5ea0-4a2e-a8e2-f978c0f1e5c5");
define('ONE_SIGNAL_PATIENT_APP_ID', "4384f500-6b4a-4db3-a370-5bdc2407e51d");

define('OTP_FROM_EMAIL', "mitul.bhadeshiya@gmail.com");

define('YOUR_OTP_FOR_MONDOC', "Your Mondoc OTP is: ");


/*  CONSTATN STRING LIST START */

define('EMAIL_SUBJ_VERIFY', "MonDoc:: Email varification OTP");
define('OTP_RESET_SUBJ', "OTP to reset your password.");
 
define('EMAIL_ADDRESS_PASSWORD_BOTH_REQUIRED', "email_address_password_both_required");
define('INVALID_EMMAIL_OR_PASSWORD', "invalid_email_or_password");
define('MOBILE_NUMBER_AND_PASSWORD_BOTH_REQUIRED', "mobile_number_and_password_both_required");
define('PLEASE_ENTER_FULLNAME', "please_enter_fullname");
define('PLEASE_ENTER_MOBILE_NUMBER', "please_enter_mobile_number");
define('PLEASE_ENTER_AGE', "please_enter_age");
define('PLEASE_SELECT_GENDER', "please_select_gender");
define('PLEASE_ENTER_PASSWORD', "please_enter_password");
define('MOBILE_ALREADY_EXIST', "mobile_already_exist");
define('PATIENT_REGISTERD_SUCCESSFULLY', "patient_registered_successfully");
define('USER_ID_REQUIRED', "user_id_required");
define('OTP_REQUIRED', "otp_required");
define('OTP_VERIFIED_SUCCESSFULLY', "otp_verified_successfully");
define('OTP_NOT_VARIFIED_PLEASE_TRY_AGAIN', "otp_not_varifiend_please_try_again");
define('SOMETHING_WENT_WRONG', "something_went_wrong");
define('ID_REQUIRED', "id_required");
define('TYPE_REQUIRED', "type_required");
define('PLEASE_ENTER_NEW_EMAIL_ADDRESS', "please_enter_new_email_address");
define('SORRY_WE_ARE_UNABLE_TO_SEND_YOU_OTP_PLEASE_TRY_AGAIN_OR_CONTACT_SUPPORT', "sorry_we_are_unable_to_send_you_otp_please_try_again_or_contact_support");
define('WE_HAVE_SENT_AN_OTP_TO_YOUR_EMAIL_ADDRESS_KINDLY_CONFIRM', "we_have_sent_an_otp_to_your_email_address_kindly_confirm");
define('EMAIL_OR_OTP_MISSING', "email_or_otp_missing");
define('ENTER_DOCTOR_ID', "enter_doctor_id");
define('EMAIL_UPDATED', "email_updated");
define('EMAIL_VERIFICATION_FAILD', "email_verification_failed");
define('PLEASE_ENTER_ID', "please_enter_id");
define('PLEASE_ENTER_TYPE', "please_enter_type");
define('PLEASE_ENTER_EMAIL_ADDRESS', "please_enter_email_address");
define('PLEASE_ENTER_CURRENT_PASSWORD', "please_enter_current_password");
define('PLEASE_ENTER_NEW_PASSWORD', "please_enter_new_password");
define('INVALID_CURRENT_PASSWORD', "invalid_current_password");
define('PASSWORD_UPDATED', "password_updated");
define('PLEASE_ENTER_YOUR_EMAIL_ADDRESS', "please_enter_your_email_address");
define('INVALID_USER', "invalid_user");
define('PLEASE_ENTER_YOUR_MOBILE_NUMBER', "please_enter_your_mobile_number");
define('PLEASE_ENTER_COUNTRY_CODE', "please_enter_country_code");
define('OTP_SENT_SUCCESSFULLY', "otp_sent_successfully");
define('FAIL_TO_SENT_OTP', "fail_to_sent_otp");
define('VERIFICATION_FAILED', "verification_failed");
define('INVALID_USER_TYPE', "invalid_user_type");
define('ALL_FIELDS_REQUIRED', "all_fields_required");
define('PASSWORD_HAS_BEEN_CHANGED_SUCCESSFULLY', "password_has_been_changed_successfully");
define('SORRY_WE_COULD_NOT_CHANGE_YOUR_PASSWORD_TRY_AGAIN_OR_CONTACT_SUPPORT', "sorry_we_could_not_change_your_password_try_again_or_contact_support");
define('FULLNAME_REQUIRED', "fullname_required");
define('QUALIFICATION_REQUIRED', "qualification_required");
define('SPECIALITY_REQUIRED', "speciality_required");
define('EXPERIENCE_REQUIRED', "experience_required");
define('GENDER_REQUIRED', "gender_required");
define('CONSULTATION_CHARGE_REQUIRED', "consultation_charge_required");
define('DOCTOR_ID_REQUIRED', "doctor_id_required");
define('THIS_TYPE_OF_FILE_NOT_ALLOWED', "this_type_of_file_not_allowed");
define('DOCTOR_DETAILS_UPDATED_SUCCESSFULLY', "doctor_details_updated_successfully");
define('DATE_REQUIRED', "date_required");
define('NO_DATA_FOUND', "no_data_found");
define('PLEASE_ENTER_DOCTOR_ID', "please_enter_doctor_id");
define('PLEASE_ENTER_APPOINTMENT_TIME_SLOT', "please_enter_appointment_time_slot");
define('PLEASE_SELECT_CONSULTATION_HOURS', "please_select_consultation_hours");
define('SUCCESS', "success");
define('APPOINTMENT_ID_REQUIRED', "appointment_id_required");
define('APPOINTMENT_CANCELED', "appointment_canceled");
define('APPOINTMENT_CANCEL_BY_DOCTOR', "appointment_cancel_by_doctor");
define('APPOINTMENT_CANCEL_BY_PATIENT', "appointment_cancel_by_patient");
define('CANT_CANCEL_APPOINTMENT', "cant_cancel_appointment");
define('NOTIFY_REQUIRED', "notify_required");
define('PATIENT_ID_REQUIRED', "patient_id_required");
define('MOBILE_REQUIRED', "mobile_required");
define('COUNTRY_CODE_REQUIRED', "country_code_required");
define('PATIENT_DETAILS_UPDATED_SUCCESSFULLY', "patient_details_updated_successfully");
define('TIME_REQUIRED', "time_required");
define('APPOINTMENT_UPPDATED', "appointment_updated");
define('APPOINTMENT_SAVE_SUCCESSFULLY', "appointment_save_successfullly");
define('MONTH_REQUIRED', "month_required");
define('YEAR_REQUIRED', "year_required");
define('PAGE_ID_REQUIRED', "page_id_required");
define('STATUS_REQUIRED', "status_required");
define('YOUR_APPOINTMENT_ACCEPTED_BY_DOCTOR', "your_appointment_accepted_by_doctor");
define('YOUR_APPOINTMENT_ACCEPTED_BY_PATIENT', "appointment_accepted_by_patient");
define('APPOINTMET_ACCEPTED', "appointment_accepted");
define('CANT_ACCEPT_APPOINTMENT', "cant_accept_appointment");
define('STATUS_CHANGE_SUCCESSFULLY', "status_change_successfully");
define('CANT_COMPLETED_APPOINTMENT', "cant_completed_appointment");
define('DESCRIPTION_REQUIRED', "description_required");
define('PRESCRIPTION_ADDED', "prescription_added");
define('PRESCIRPTION_ID_REQUIRED', "prescription_id_required");
define('PRESCRIPTION_UPDATED', "prescription_updated");

//Frontend
define('SITE_FRONTEND_JS', BASE_URL.'assets/frontend/js/');
define('SITE_FRONTEND_CSS', BASE_URL.'assets/frontend/css/');
define('SITE_FRONTEND_IMAGES', BASE_URL.'assets/frontend/images/');


/*  CONSTATN STRING LIST END */

define("SITE_INC", BASE_URL . "includes/");
define('SITE_THEME', '#00318C');
define('SITE_FONTS', 'https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');
define('VER','?v='.randomString());

function randomString($length = 10) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
};

