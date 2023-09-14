В проекте для 3 трех типов доставки используются слдеующие ссылки:
Медленная:
http://dima2.local/affordable/slow?cm=1&source_kladr=Брянск&target_kladr=Moskow&weight=100,1
Быстрая:
http://dima2.local/affordable/fast?cm=1,2,1888,303,200&source_kladr=Braynsk&target_kladr=Moskow&weight=100,1
Смещанная:
http://dima2.local/affordable/mixed?sl_cm=1,2,1888,303,200&fs_cm=400,600,123&source_kladr=Braynsk&target_kladr=Moskow&weight=100,1

Конфиги nginx будут приведены в паке config
local: нужно название локал домена добавить know_hosts
prod:в bind домена нужно добавить cтрочку api IN A {IP}(в названии конфига nginx учесть это)
 Версия php 7.3
