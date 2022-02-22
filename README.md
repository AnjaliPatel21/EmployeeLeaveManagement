Create Empty laravel project and clone this repo into that project 
run migrations
create one entry for admin in table 'users' with 'is_admin' filed as '1'. That user will be considered as admin
set SMTP configuration to send mail in .env file lile : 
                    MAIL_DRIVER=smtp
                    MAIL_HOST=smtp.gmail.com
                    MAIL_PORT=587
                    MAIL_USERNAME=your_email
                    MAIL_PASSWORD=your_pwd
                    MAIL_ENCRYPTION=tls
                    MAIL_FROM_ADDRESS=your_email
                    MAIL_FROM_NAME="${APP_NAME}"
User can login,register, apply leave
Admin can approve/decline leave, approve registration request. 
