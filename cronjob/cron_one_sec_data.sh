now=`date +%H%M`
while true; do
    begin=`date +%s`
    php /var/www/html/public/index.php NotificationController send_Notification

    end=`date +%s`
    if [ $(($end - $begin)) -lt 1 ]; then
        sleep $(($begin + 3 - $end))
    fi
    
    echo " current time:- `date +%T`"
    
    if [ $now -eq 2359 ]
   then
    break
   fi

    now=`date +%H%M`
done