update sensor set type = 'IT' where name='Internal Temperature';
update sensor set type = 'ET' where name='External Temperature';

update sensor set type = 'IH' where name='Internal Humidity';
update sensor set type = 'EH' where name='External Humidity';


update sensor set type = 'WS' where name='Wind Speed';
update sensor set type = 'WD' where name='Wind Direction';
update sensor set type = 'DR' where name='Daily Rain';
update sensor set type = 'BP' where name='Barometric Pressure';


update sensor set type = 'PM1' where name='PM1';
update sensor set type = 'PM2_5' where name='PM2.5';
update sensor set type = 'PM5' where name='PM5';
update sensor set type = 'PM10' where name='PM10';

update sensor set type = 'OD' where name='Odour';
update sensor set type = 'OD' where name='Odour Unit';


update sensor set type = 'HS1' where name='Hydrogen Sulfide - LC' or name='Hydrogen Sulfide -LC' or name='Hydrogen Sulfide-LC';
update sensor set type = 'SD2' where name='Sulfur Dioxide - LC' or name='Sulfur Dioxide- LC' or name='Sulfur Dioxide -LC';


update sensor set type = 'CD1' where name ilike 'Carbon Dioxide-LC%' or name ilike 'Carbon Dioxide - LC%' or name ilike 'Carbon Dioxide -LC%' or name ilike 'Carbon Dioxide- LC%';
update sensor set type = 'CD2' where name ilike 'Carbon Dioxide-HC%' or name ilike 'Carbon Dioxide - HC%' or name ilike 'Carbon Dioxide -HC%' or name ilike 'Carbon Dioxide- HC%';
