 #!/bin/bash
        for i in $( ls /tmp/UNPROCESSED*); do
           `php /var/www/html/clientes/easygtd/src/trunk/batch/inbox-inyector.php $i`
           `rm -f $i`
        done
