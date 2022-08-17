<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

function get_message_localised($message , $lang_id)
{
    if ($lang_id == 'ar'){

        if($message ==  EMAIL_ADDRESS_PASSWORD_BOTH_REQUIRED) {
            return "مطلوب كل من عنوان البريد الإلكتروني وكلمة المرور.";
        }else if($message == INVALID_EMMAIL_OR_PASSWORD){
            return "البريد الإلكتروني أو كلمة السر خاطئة";
        }else if($message == MOBILE_NUMBER_AND_PASSWORD_BOTH_REQUIRED){
            return "رقم الهاتف المحمول وكلمة المرور كلاهما مطلوب.";
        }else if($message == PLEASE_ENTER_FULLNAME){
            return "الرجاء إدخال الاسم الكامل";
        }else if($message == PLEASE_ENTER_MOBILE_NUMBER){
            return "الرجاء إدخال رقم الهاتف المحمول";
        }else if($message == PLEASE_ENTER_AGE){
            return "الرجاء إدخال العمر";
        }else if($message == PLEASE_SELECT_GENDER){
            return "يرجى تحديد الجنس";
        }else if($message == PLEASE_ENTER_PASSWORD){
            return "الرجاء إدخال كلمة المرور";
        }else if($message == MOBILE_ALREADY_EXIST){
            return "الجوال موجود بالفعل ..";
        }else if($message == PATIENT_REGISTERD_SUCCESSFULLY){
            return "تم تسجيل المريض بنجاح ..";
        }else if($message == USER_ID_REQUIRED){
            return "معرف المستخدم مطلوب.";
        }else if($message == OTP_REQUIRED){
            return "مطلوب OTP.";
        }else if($message == OTP_VERIFIED_SUCCESSFULLY){
            return "تم التحقق من OTP بنجاح.";
        }else if($message == OTP_NOT_VARIFIED_PLEASE_TRY_AGAIN){
            return "OTP not varifiend please try again.";
        }else if($message == SOMETHING_WENT_WRONG){
            return "هناك خطأ ما";
        }else if($message == ID_REQUIRED){
            return "المعرف مطلوب.";
        }else if($message == TYPE_REQUIRED){
            return "النوع مطلوب.";
        }else if($message == PLEASE_ENTER_NEW_EMAIL_ADDRESS){
            return "الرجاء إدخال عنوان بريد إلكتروني جديد.";
        }else if($message == SORRY_WE_ARE_UNABLE_TO_SEND_YOU_OTP_PLEASE_TRY_AGAIN_OR_CONTACT_SUPPORT){
            return "عذرا ، لا يمكننا أن نرسل لك OTP. يرجى المحاولة مرة أخرى أو احتوى على الدعم.";
        }else if($message == WE_HAVE_SENT_AN_OTP_TO_YOUR_EMAIL_ADDRESS_KINDLY_CONFIRM){
            return "لقد أرسلنا OTP إلى عنوان بريدك الإلكتروني. يرجى التأكيد.";
        }else if($message == EMAIL_OR_OTP_MISSING){
            return "البريد الإلكتروني أو OTP مفقود.";
        }else if($message == ENTER_DOCTOR_ID){
            return "أدخل معرف الطبيب";
        }else if($message == EMAIL_UPDATED){
            return "تم تحديث البريد الإلكتروني.";
        }else if($message == EMAIL_VERIFICATION_FAILD){
            return "فشل التحقق من البريد الإلكتروني.";
        }else if($message == PLEASE_ENTER_ID){
            return "الرجاء إدخال الهوية.";
        }else if($message == PLEASE_ENTER_TYPE){
            return "الرجاء إدخال النوع.";
        }else if($message == PLEASE_ENTER_EMAIL_ADDRESS){
            return "الرجاء إدخال عنوان البريد الإلكتروني.";
        }else if($message == PLEASE_ENTER_CURRENT_PASSWORD){
            return "الرجاء إدخال كلمة المرور الحالية.";
        }else if($message == PLEASE_ENTER_NEW_PASSWORD){
            return "الرجاء إدخال كلمة المرور الجديدة.";
        }else if($message == INVALID_CURRENT_PASSWORD){
            return "كلمة مرور غير صحيحة.";
        }else if($message == PASSWORD_UPDATED){
            return "تم تحديث كلمة السر.";
        }else if($message == PLEASE_ENTER_YOUR_EMAIL_ADDRESS){
            return "الرجاء إدخال عنوان البريد الإلكتروني الخاص بك";
        }else if($message == INVALID_USER){
            return "مستخدم غير صالح.";
        }else if($message == PLEASE_ENTER_YOUR_MOBILE_NUMBER){
            return "الرجاء إدخال رقم هاتفك المحمول";
        }else if($message == PLEASE_ENTER_COUNTRY_CODE){
            return "الرجاء إدخال رمز الدولة";
        }else if($message == OTP_SENT_SUCCESSFULLY){
            return "تم إرسال OTP بنجاح.";
        }else if($message == FAIL_TO_SENT_OTP){
            return "فشل في إرسال OPT";
        }else if($message == VERIFICATION_FAILED){
            return "فشل التحقق.";
        }else if($message == INVALID_USER_TYPE){
            return "نوع المستخدم غير صالح";
        }else if($message == ALL_FIELDS_REQUIRED){
            return "جميع الحقول مطلوبة.";
        }else if($message == PASSWORD_HAS_BEEN_CHANGED_SUCCESSFULLY){
            return "تم تغيير كلمة المرور بنجاح.";
        }else if($message == SORRY_WE_COULD_NOT_CHANGE_YOUR_PASSWORD_TRY_AGAIN_OR_CONTACT_SUPPORT){
            return "عذرا ، لم نتمكن من تغيير كلمة المرور الخاصة بك. حاول مرة أخرى أو اتصل بالدعم.";
        }else if($message == FULLNAME_REQUIRED){
            return "الاسم الكامل مطلوب.";
        }else if($message == QUALIFICATION_REQUIRED){
            return "المؤهلات المطلوبة.";
        }else if($message == SPECIALITY_REQUIRED){
            return "التخصص المطلوب.";
        }else if($message == EXPERIENCE_REQUIRED){
            return "الخبرات المطلوبة.";
        }else if($message == GENDER_REQUIRED){
            return "الجنس مطلوب.";
        }else if($message == CONSULTATION_CHARGE_REQUIRED){
            return "رسوم التشاور المطلوبة.";
        }else if($message == DOCTOR_ID_REQUIRED){
            return "معرف الطبيب مطلوب.";
        }else if($message == THIS_TYPE_OF_FILE_NOT_ALLOWED){
            return "هذا النوع من الملفات غير مسموح به.";
        }else if($message == DOCTOR_DETAILS_UPDATED_SUCCESSFULLY){
            return "تحديث تفاصيل الطبيب بنجاح ..";
        }else if($message == DATE_REQUIRED){
            return "التاريخ مطلوب.";
        }else if($message == NO_DATA_FOUND){
            return "لاتوجد بيانات!";
        }else if($message == PLEASE_ENTER_DOCTOR_ID){
            return "الرجاء إدخال معرف الطبيب.";
        }else if($message == PLEASE_ENTER_APPOINTMENT_TIME_SLOT){
            return "الرجاء إدخال خانة وقت الموعد.";
        }else if($message == PLEASE_SELECT_CONSULTATION_HOURS){
            return "الرجاء تحديد ساعات الاستشارة.";
        }else if($message == SUCCESS){
            return "نجاح..";
        }else if($message == APPOINTMENT_ID_REQUIRED){
            return "مطلوب معرف الموعد ..";
        }else if($message == APPOINTMENT_CANCELED){
            return "تم إلغاء الموعد.";
        }else if($message == APPOINTMENT_CANCEL_BY_DOCTOR){
            return "إلغاء الموعد من قبل الطبيب.";
        }else if($message == APPOINTMENT_CANCEL_BY_PATIENT){
            return "إلغاء الموعد من قبل المريض.";
        }else if($message == CANT_CANCEL_APPOINTMENT){
            return "لا يمكن إلغاء الموعد.";
        }else if($message == NOTIFY_REQUIRED){
            return "يخطر المطلوب.";
        }else if($message == PATIENT_ID_REQUIRED){
            return "معرف المريض مطلوب.";
        }else if($message == MOBILE_REQUIRED){
            return "الجوال مطلوب.";
        }else if($message == COUNTRY_CODE_REQUIRED){
            return "رمز البلد مطلوب.";
        }else if($message == PATIENT_DETAILS_UPDATED_SUCCESSFULLY){
            return "تحديث تفاصيل المريض بنجاح ..";
        }else if($message == TIME_REQUIRED){
            return "الوقت اللازم.";
        }else if($message == APPOINTMENT_UPPDATED){
            return "تم تحديث الموعد.";
        }else if($message == APPOINTMENT_SAVE_SUCCESSFULLY){
            return "تم حفظ الموعد بنجاح ..";
        }else if($message == MONTH_REQUIRED){
            return "الشهر المطلوب.";
        }else if($message == YEAR_REQUIRED){
            return "السنة المطلوبة.";
        }else if($message == PAGE_ID_REQUIRED){
            return "معرف الصفحة مطلوب.";
        }else if($message == STATUS_REQUIRED){
            return "الحالة مطلوبة.";
        }else if($message == YOUR_APPOINTMENT_ACCEPTED_BY_DOCTOR){
            return "موعدك قبل الطبيب";
        }else if($message == YOUR_APPOINTMENT_ACCEPTED_BY_PATIENT){
            return "الموعد مقبول من قبل المريض.";
        }else if($message == APPOINTMET_ACCEPTED){
            return "تم قبول التعيين.";
        }else if($message == CANT_ACCEPT_APPOINTMENT){
            return "لا يمكن قبول الموعد.";
        }else if($message == STATUS_CHANGE_SUCCESSFULLY){
            return "تم تغيير الوضع بنجاح.";
        }else if($message == CANT_COMPLETED_APPOINTMENT){
            return "لا يمكن إكمال الموعد.";
        }else if($message == DESCRIPTION_REQUIRED){
            return "الوصف مطلوب.";
        }else if($message == PRESCRIPTION_ADDED){
            return "الوصفة المضافة";
        }else if($message == PRESCIRPTION_ID_REQUIRED){
            return "مطلوب معرف وصفة طبية.";
        }else if($message == PRESCRIPTION_UPDATED){
            return "تم تحديث الوصفة";
        }

    }else if($lang_id == 'fr'){

        if($message ==  EMAIL_ADDRESS_PASSWORD_BOTH_REQUIRED) {
            return "Adresse e-mail et mot de passe requis.";
        }else if($message == INVALID_EMMAIL_OR_PASSWORD){
            return "Email ou mot de passe invalide";
        }else if($message == MOBILE_NUMBER_AND_PASSWORD_BOTH_REQUIRED){
            return "numéro de téléphone portable et mot de passe requis.";
        }else if($message == PLEASE_ENTER_FULLNAME){
            return "Veuillez entrer le nom complet";
        }else if($message == PLEASE_ENTER_MOBILE_NUMBER){
            return "Veuillez entrer le numéro de portable";
        }else if($message == PLEASE_ENTER_AGE){
            return "Veuillez entrer l'âge";
        }else if($message == PLEASE_SELECT_GENDER){
            return "Veuillez sélectionner le sexe";
        }else if($message == PLEASE_ENTER_PASSWORD){
            return "Veuillez entrer le mot de passe";
        }else if($message == MOBILE_ALREADY_EXIST){
            return "mobile existe déjà..";
        }else if($message == PATIENT_REGISTERD_SUCCESSFULLY){
            return "Patient enregistré avec succès..";
        }else if($message == USER_ID_REQUIRED){
            return "Identifiant d'utilisateur requis.";
        }else if($message == OTP_REQUIRED){
            return "OTP requis.";
        }else if($message == OTP_VERIFIED_SUCCESSFULLY){
            return "OTP vérifié avec succès.";
        }else if($message == OTP_NOT_VARIFIED_PLEASE_TRY_AGAIN){
            return "OTP not varifiend please try again.";
        }else if($message == SOMETHING_WENT_WRONG){
            return "quelque chose s'est mal passé";
        }else if($message == ID_REQUIRED){
            return "Pièce d'identité requise.";
        }else if($message == TYPE_REQUIRED){
            return "Type requis.";
        }else if($message == PLEASE_ENTER_NEW_EMAIL_ADDRESS){
            return "Veuillez saisir une nouvelle adresse e-mail.";
        }else if($message == SORRY_WE_ARE_UNABLE_TO_SEND_YOU_OTP_PLEASE_TRY_AGAIN_OR_CONTACT_SUPPORT){
            return "Désolé, nous ne pouvons pas vous envoyer OTP. Veuillez réessayer ou contacter l'assistance.";
        }else if($message == WE_HAVE_SENT_AN_OTP_TO_YOUR_EMAIL_ADDRESS_KINDLY_CONFIRM){
            return "Nous avons envoyé un OTP à votre adresse e-mail. De bien vouloir confirmer.";
        }else if($message == EMAIL_OR_OTP_MISSING){
            return "E-mail ou OTP manquant.";
        }else if($message == ENTER_DOCTOR_ID){
            return "Entrez l'identifiant du médecin";
        }else if($message == EMAIL_UPDATED){
            return "E-mail mis à jour.";
        }else if($message == EMAIL_VERIFICATION_FAILD){
            return "La vérification de l'e-mail a échoué.";
        }else if($message == PLEASE_ENTER_ID){
            return "Veuillez entrer l'identifiant.";
        }else if($message == PLEASE_ENTER_TYPE){
            return "Veuillez saisir le type.";
        }else if($message == PLEASE_ENTER_EMAIL_ADDRESS){
            return "Veuillez saisir l'adresse e-mail.";
        }else if($message == PLEASE_ENTER_CURRENT_PASSWORD){
            return "Veuillez saisir le mot de passe actuel.";
        }else if($message == PLEASE_ENTER_NEW_PASSWORD){
            return "Veuillez saisir un nouveau mot de passe.";
        }else if($message == INVALID_CURRENT_PASSWORD){
            return "Mot de passe actuel invalide.";
        }else if($message == PASSWORD_UPDATED){
            return "Mot de passe mis à jour.";
        }else if($message == PLEASE_ENTER_YOUR_EMAIL_ADDRESS){
            return "Veuillez saisir votre adresse e-mail";
        }else if($message == INVALID_USER){
            return "Utilisateur invalide.";
        }else if($message == PLEASE_ENTER_YOUR_MOBILE_NUMBER){
            return "Entrez s'il vous plaît votre numéro de téléphone";
        }else if($message == PLEASE_ENTER_COUNTRY_CODE){
            return "Veuillez entrer le code du pays";
        }else if($message == OTP_SENT_SUCCESSFULLY){
            return "OTP envoyé avec succès.";
        }else if($message == FAIL_TO_SENT_OTP){
            return "échec de l'envoi de l'OPT";
        }else if($message == VERIFICATION_FAILED){
            return "Échec de la vérification.";
        }else if($message == INVALID_USER_TYPE){
            return "Type d'utilisateur non valide";
        }else if($message == ALL_FIELDS_REQUIRED){
            return "Tous les champs sont obligatoires.";
        }else if($message == PASSWORD_HAS_BEEN_CHANGED_SUCCESSFULLY){
            return "Le mot de passe a été changé avec succès.";
        }else if($message == SORRY_WE_COULD_NOT_CHANGE_YOUR_PASSWORD_TRY_AGAIN_OR_CONTACT_SUPPORT){
            return "Désolé, nous n'avons pas pu changer votre mot de passe. Réessayez ou contactez l'assistance.";
        }else if($message == FULLNAME_REQUIRED){
            return "Nom complet requis.";
        }else if($message == QUALIFICATION_REQUIRED){
            return "Diplôme requis.";
        }else if($message == SPECIALITY_REQUIRED){
            return "Spécialité exigée.";
        }else if($message == EXPERIENCE_REQUIRED){
            return "Expérience requise.";
        }else if($message == GENDER_REQUIRED){
            return "Sexe requis.";
        }else if($message == CONSULTATION_CHARGE_REQUIRED){
            return "Frais de consultation exigés.";
        }else if($message == DOCTOR_ID_REQUIRED){
            return "Pièce d'identité du médecin requise.";
        }else if($message == THIS_TYPE_OF_FILE_NOT_ALLOWED){
            return "Ce type de fichier n'est pas autorisé.";
        }else if($message == DOCTOR_DETAILS_UPDATED_SUCCESSFULLY){
            return "Les détails du médecin ont été mis à jour avec succès.";
        }else if($message == DATE_REQUIRED){
            return "Date requise.";
        }else if($message == NO_DATA_FOUND){
            return "Aucune donnée disponible!";
        }else if($message == PLEASE_ENTER_DOCTOR_ID){
            return "Veuillez saisir l'identifiant du médecin.";
        }else if($message == PLEASE_ENTER_APPOINTMENT_TIME_SLOT){
            return "Veuillez entrer le créneau horaire du rendez-vous.";
        }else if($message == PLEASE_SELECT_CONSULTATION_HOURS){
            return "Veuillez sélectionner les heures de consultation.";
        }else if($message == SUCCESS){
            return "Succès..";
        }else if($message == APPOINTMENT_ID_REQUIRED){
            return "Identifiant de rendez-vous requis..";
        }else if($message == APPOINTMENT_CANCELED){
            return "Rendez-vous annulé.";
        }else if($message == APPOINTMENT_CANCEL_BY_DOCTOR){
            return "Annulation de rendez-vous par le médecin.";
        }else if($message == APPOINTMENT_CANCEL_BY_PATIENT){
            return "Annulation de rendez-vous par le patient.";
        }else if($message == CANT_CANCEL_APPOINTMENT){
            return "Impossible d'annuler le rendez-vous.";
        }else if($message == NOTIFY_REQUIRED){
            return "Avis obligatoire.";
        }else if($message == PATIENT_ID_REQUIRED){
            return "Identifiant du patient requis.";
        }else if($message == MOBILE_REQUIRED){
            return "Mobile requis.";
        }else if($message == COUNTRY_CODE_REQUIRED){
            return "Code pays requis.";
        }else if($message == COUNTRY_CODE_REQUIRED){
            return "Code pays requis.";
        }else if($message == PATIENT_DETAILS_UPDATED_SUCCESSFULLY){
            return "Les détails du patient ont été mis à jour avec succès.";
        }else if($message == TIME_REQUIRED){
            return "Temps requis.";
        }else if($message == APPOINTMENT_UPPDATED){
            return "Rendez-vous mis à jour.";
        }else if($message == APPOINTMENT_SAVE_SUCCESSFULLY){
            return "Rendez-vous enregistré avec succès..";
        }else if($message == MONTH_REQUIRED){
            return "Mois requis.";
        }else if($message == YEAR_REQUIRED){
            return "Année requise.";
        }else if($message == PAGE_ID_REQUIRED){
            return "Identifiant de page requis.";
        }else if($message == STATUS_REQUIRED){
            return "Statut requis.";
        }else if($message == YOUR_APPOINTMENT_ACCEPTED_BY_DOCTOR){
            return "Votre rendez-vous accepté par le médecin";
        }else if($message == YOUR_APPOINTMENT_ACCEPTED_BY_PATIENT){
            return "Rendez-vous accepté par le patient.";
        }else if($message == APPOINTMET_ACCEPTED){
            return "Rendez-vous accepté.";
        }else if($message == CANT_ACCEPT_APPOINTMENT){
            return "Impossible d'accepter le rendez-vous.";
        }else if($message == STATUS_CHANGE_SUCCESSFULLY){
            return "Le statut a été modifié avec succès.";
        }else if($message == CANT_COMPLETED_APPOINTMENT){
            return "Impossible de terminer le rendez-vous.";
        }else if($message == DESCRIPTION_REQUIRED){
            return "Descriptif requis.";
        }else if($message == PRESCRIPTION_ADDED){
            return "Ordonnance ajoutée";
        }else if($message == PRESCIRPTION_ID_REQUIRED){
            return "PIdentifiant de prescription requis.";
        }else if($message == PRESCRIPTION_UPDATED){
            return "Ordonnance mise à jour";
        }

    }else{

        if($message ==  EMAIL_ADDRESS_PASSWORD_BOTH_REQUIRED) {
            return "Email address and Password Both Required.";
        }else if($message == INVALID_EMMAIL_OR_PASSWORD){
            return "Invalid Email or Password";
        }else if($message == MOBILE_NUMBER_AND_PASSWORD_BOTH_REQUIRED){
            return "mobile number and Password Both Required.";
        }else if($message == PLEASE_ENTER_FULLNAME){
            return "Please enter fullname";
        }else if($message == PLEASE_ENTER_MOBILE_NUMBER){
            return "Please enter mobile number";
        }else if($message == PLEASE_ENTER_AGE){
            return "Please enter age";
        }else if($message == PLEASE_SELECT_GENDER){
            return "Please select gender";
        }else if($message == PLEASE_ENTER_PASSWORD){
            return "Please enter password";
        }else if($message == MOBILE_ALREADY_EXIST){
            return "mobile already exist..";
        }else if($message == PATIENT_REGISTERD_SUCCESSFULLY){
            return "Patient registered successfully..";
        }else if($message == USER_ID_REQUIRED){
            return "User Id required.";
        }else if($message == OTP_REQUIRED){
            return "OTP required.";
        }else if($message == OTP_VERIFIED_SUCCESSFULLY){
            return "OTP verified successfully.";
        }else if($message == OTP_NOT_VARIFIED_PLEASE_TRY_AGAIN){
            return "OTP not varifiend please try again.";
        }else if($message == SOMETHING_WENT_WRONG){
            return "something went wrong";
        }else if($message == ID_REQUIRED){
            return "Id required.";
        }else if($message == TYPE_REQUIRED){
            return "Type required.";
        }else if($message == PLEASE_ENTER_NEW_EMAIL_ADDRESS){
            return "Please enter email address.";
        }else if($message == SORRY_WE_ARE_UNABLE_TO_SEND_YOU_OTP_PLEASE_TRY_AGAIN_OR_CONTACT_SUPPORT){
            return "Sorry, we are unable to send you OTP. Please try again or contanct support.";
        }else if($message == WE_HAVE_SENT_AN_OTP_TO_YOUR_EMAIL_ADDRESS_KINDLY_CONFIRM){
            return "We have sent an OTP to your email address. Kindly confirm.";
        }else if($message == EMAIL_OR_OTP_MISSING){
            return "Email or OTP missing.";
        }else if($message == ENTER_DOCTOR_ID){
            return "Enter Doctor id";
        }else if($message == EMAIL_UPDATED){
            return "Email updated.";
        }else if($message == EMAIL_VERIFICATION_FAILD){
            return "Email Verification failed.";
        }else if($message == PLEASE_ENTER_ID){
            return "Please enter id.";
        }else if($message == PLEASE_ENTER_TYPE){
            return "Please enter type.";
        }else if($message == PLEASE_ENTER_EMAIL_ADDRESS){
            return "Please enter email address.";
        }else if($message == PLEASE_ENTER_CURRENT_PASSWORD){
            return "Please enter current password.";
        }else if($message == PLEASE_ENTER_NEW_PASSWORD){
            return "Please enter new password.";
        }else if($message == INVALID_CURRENT_PASSWORD){
            return "Invalid current password.";
        }else if($message == PASSWORD_UPDATED){
            return "Password updated.";
        }else if($message == PLEASE_ENTER_YOUR_EMAIL_ADDRESS){
            return "Please enter your email address";
        }else if($message == INVALID_USER){
            return "Invalid user.";
        }else if($message == PLEASE_ENTER_YOUR_MOBILE_NUMBER){
            return "Please enter your mobile number";
        }else if($message == PLEASE_ENTER_COUNTRY_CODE){
            return "Please enter country code";
        }else if($message == OTP_SENT_SUCCESSFULLY){
            return "OTP sent successfully.";
        }else if($message == FAIL_TO_SENT_OTP){
            return "failed to sent OPT";
        }else if($message == VERIFICATION_FAILED){
            return "Verification failed.";
        }else if($message == INVALID_USER_TYPE){
            return "Invalid user type";
        }else if($message == ALL_FIELDS_REQUIRED){
            return "All fields required.";
        }else if($message == PASSWORD_HAS_BEEN_CHANGED_SUCCESSFULLY){
            return "Password has been changed successfully.";
        }else if($message == SORRY_WE_COULD_NOT_CHANGE_YOUR_PASSWORD_TRY_AGAIN_OR_CONTACT_SUPPORT){
            return "Sorry, we could not change your password. Try again or contact support.";
        }else if($message == FULLNAME_REQUIRED){
            return "Fullname required.";
        }else if($message == QUALIFICATION_REQUIRED){
            return "Qualification required.";
        }else if($message == SPECIALITY_REQUIRED){
            return "Speciality required.";
        }else if($message == EXPERIENCE_REQUIRED){
            return "Experience required.";
        }else if($message == GENDER_REQUIRED){
            return "Gender required.";
        }else if($message == CONSULTATION_CHARGE_REQUIRED){
            return "Consultation charges required.";
        }else if($message == DOCTOR_ID_REQUIRED){
            return "Doctor id required.";
        }else if($message == THIS_TYPE_OF_FILE_NOT_ALLOWED){
            return "This type of file not allowed.";
        }else if($message == DOCTOR_DETAILS_UPDATED_SUCCESSFULLY){
            return "Doctor details update successfully..";
        }else if($message == DATE_REQUIRED){
            return "Date required.";
        }else if($message == NO_DATA_FOUND){
            return "No data found!";
        }else if($message == PLEASE_ENTER_DOCTOR_ID){
            return "Please enter doctor id.";
        }else if($message == PLEASE_ENTER_APPOINTMENT_TIME_SLOT){
            return "Please enter Appointment time slot.";
        }else if($message == PLEASE_SELECT_CONSULTATION_HOURS){
            return "Please select consultation hours.";
        }else if($message == SUCCESS){
            return "Success..";
        }else if($message == APPOINTMENT_ID_REQUIRED){
            return "Appointment id required..";
        }else if($message == APPOINTMENT_CANCELED){
            return "Appointment Canceled.";
        }else if($message == APPOINTMENT_CANCEL_BY_DOCTOR){
            return "Appointment Cancel by doctor.";
        }else if($message == APPOINTMENT_CANCEL_BY_PATIENT){
            return "Appointment Cancel by patient.";
        }else if($message == CANT_CANCEL_APPOINTMENT){
            return "Can't cancel appointment.";
        }else if($message == NOTIFY_REQUIRED){
            return "Notify required.";
        }else if($message == PATIENT_ID_REQUIRED){
            return "Patient id required.";
        }else if($message == MOBILE_REQUIRED){
            return "Mobile required.";
        }else if($message == COUNTRY_CODE_REQUIRED){
            return "Country code required.";
        }else if($message == COUNTRY_CODE_REQUIRED){
            return "Country code required.";
        }else if($message == PATIENT_DETAILS_UPDATED_SUCCESSFULLY){
            return "Patient details update successfully..";
        }else if($message == TIME_REQUIRED){
            return "Time required.";
        }else if($message == APPOINTMENT_UPPDATED){
            return "Appointment updated.";
        }else if($message == APPOINTMENT_SAVE_SUCCESSFULLY){
            return "Appointment save successfully..";
        }else if($message == MONTH_REQUIRED){
            return "Month required.";
        }else if($message == YEAR_REQUIRED){
            return "Year required.";
        }else if($message == PAGE_ID_REQUIRED){
            return "Page id required.";
        }else if($message == STATUS_REQUIRED){
            return "Status required.";
        }else if($message == YOUR_APPOINTMENT_ACCEPTED_BY_DOCTOR){
            return "Your appointment accepted by doctor";
        }else if($message == YOUR_APPOINTMENT_ACCEPTED_BY_PATIENT){
            return "Appointment accepted by patient.";
        }else if($message == APPOINTMET_ACCEPTED){
            return "Appointment accepted.";
        }else if($message == CANT_ACCEPT_APPOINTMENT){
            return "Can't accept appointment.";
        }else if($message == STATUS_CHANGE_SUCCESSFULLY){
            return "Status changed successfully.";
        }else if($message == CANT_COMPLETED_APPOINTMENT){
            return "Can't complete appointment.";
        }else if($message == DESCRIPTION_REQUIRED){
            return "Description required.";
        }else if($message == PRESCRIPTION_ADDED){
            return "Prescription added";
        }else if($message == PRESCIRPTION_ID_REQUIRED){
            return "Prescription id required.";
        }else if($message == PRESCRIPTION_UPDATED){
            return "Prescription updated";
        }

    }
    return $message;
}
