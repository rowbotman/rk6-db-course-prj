server {
        listen 80; # порт, прослушивающий nginx
        server_name    coursacheit.com; # доменное имя, относящиеся к текущему виртуальному хосту
        root  /home/astronaut/Desktop/bmstu/DataBase/rk6-db-course-prj/; # каталог в котором лежит проект, путь к точке входа


        index index.php;
        # add_header Access-Control-Allow-Origin *;


        # serve static files directly
        location ~* \.(jpg|jpeg|gif|css|png|js|ico|html)$ {
                access_log off;
                expires max;
                log_not_found off;
        }


        location / {
                # add_header Access-Control-Allow-Origin *;
                try_files $uri $uri/ /index.php?$query_string;
        }

        location ~* \.php$ {
        try_files $uri = 404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php7.0-fpm.sock; # подключаем сокет php-fpm
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
                deny all;
        }
}