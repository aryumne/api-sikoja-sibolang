# Hal hal yang perlu dikonfigurasi saat proses deploy 
    1. clone project from github using git (pastikan git terinstall)
    2. pastikan php dan composer terinstall
    3. masuk ke folder project yang sudah diclone dari github
    4. copy file .env.example ke .env
    5. konfigurasi database dan APP_URL serta SESION_DRIVE dan DOMAIN_STATEFUL_SANCTUM di file .env 
    6. generate key dengan menjalankan perintah "php artisan key:generate"
    7. jalankan perintah "composer install"
    8. jalan perintah "php artisan storage:link"
    9. Ubah url pada file app/Notifications/EmailVerificationNotification.php sesuai dengan domain project admin
    10. Ubah url pada file app/models/user.php sesuai dengan domain project admin
    
