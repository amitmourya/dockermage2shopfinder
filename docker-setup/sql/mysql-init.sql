UPDATE mysql.user
    SET authentication_string = PASSWORD(''), password_expired = 'N'
        WHERE User = 'root' AND Host = 'localhost';
        FLUSH PRIVILEGES;
