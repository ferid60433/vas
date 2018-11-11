bearerbox ./docker/sms/kannel.conf &
sleep 5
echo "Bearerbox have been started"

smsbox ./docker/sms/kannel.conf &
sleep 5
echo "SMSBox have been started"

php artisan serve &

echo "All have been started"
