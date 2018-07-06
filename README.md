# corundum

Хранилище изображений и файлов.

Структура для изображений.

https://tools.ietf.org/html/rfc4122

ORIGINAL `/{bucket}/{uuid4}(.{format})`
URL `/{bucket}(/{thumbs})/{uuid4}(.{format})`

PATH ORIGINAL `/{bucket}/original/{uuid4:2}/{uuid4:2,2}//{uuid4}.{format}`
PATH `/{bucket}/{thumbs}/{uuid4:2}/{uuid4:2,2}//{uuid4}.{format}`

Нужно добавить запрет на создание конфига с именем original  

---
Форматы


1. Автоматический выбор формата. 
    - Если в заголовке есть accept webp, отдаем webp.
    - Если нет, тогда png/jpg.
    
2. Если изображение содержит альфа канал -- png, в ином случае jpg.

3. Автоматически генерируем аналогичное изображение в webp, если в представлении был включен формат webp. 

```bash
sudo apt-get install jpegoptim
sudo apt-get install optipng
sudo apt-get install pngquant
sudo npm install -g svgo
#sudo apt-get install gifsicle
```

Example
--

```bash
sudo su nobody -s /bin/sh -c "php artisan bx:service -vvv"
```

RabbitMQ
--

Management RabbitMQ [http://172.16.241.7:15672](http://172.16.241.7:15672)

---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
