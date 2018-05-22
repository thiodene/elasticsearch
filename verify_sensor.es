Select * from
sensor  left join  sensor_type
on sensor.type = sensor_type.id
where sensor_type.id is null;
