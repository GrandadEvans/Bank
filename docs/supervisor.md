# Supervisor configuration
To enable Worker automation, the following should be installed in the supervisor conf dir as
explained in the [Laravel docs](https://laravel.com/docs/8.x/queues#supervisor-configuration)

##example conf file
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php {working_dir}/artisan queue:work  --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user={user}
numprocs=8
redirect_stderr=true
stdout_logfile={working_dir}/logs/worker.log
stopwaitsecs=3600
```

Obviously, You'll have to replace the {working_dir} and {user} variables to suite your own system

## Todo
@todo I do actually intend to create a script that will add this to the config dir and make things easier.
