@echo OFF
start cmd /k "php artisan serve"
start cmd /K "C:\Users\rahma\Desktop\graduation_ham\MailHog_windows_amd64.exe"
start cmd /k "php artisan schedule:work"