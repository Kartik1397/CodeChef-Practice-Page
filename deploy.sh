#build
cd client
npm run build
cd build
tar -cvf client.tar.gz ./*
scp client.tar.gz k@40.117.233.16:~
rm client.tar.gz
cd ../../api
tar -cvf api.tar.gz src/ composer.json public/ config/ .env
scp api.tar.gz k@40.117.233.16:~
rm api.tar.gz
cd ..
ssh k@40.117.233.16 << 'ENDSSH'
rm -r ccpp
mkdir ccpp ccpp/api ccpp/client
tar -xvf client.tar.gz -C ccpp/client/
tar -xvf api.tar.gz -C ccpp/api/
rm api.tar.gz client.tar.gz
cd ccpp/api
composer install
ENDSSH