UPDATE wp_options SET option_value = replace(option_value, 'http://old-example.com', 'http://new-example.com') WHERE option_name = 'home' OR option_name = 'siteurl';
UPDATE wp_posts SET guid = replace(guid, 'http://old-example.com', 'http://new-example.com');
UPDATE wp_posts SET post_content = replace(post_content, 'http://old-example.com', 'http://new-example.com');
UPDATE wp_postmeta SET meta_value = replace(meta_value,'http://old-example.com', 'http://new-example.com');







UPDATE wp_options SET option_value = replace(option_value, 
'http://old-example.com', 
'http://new-example.com') 
WHERE option_name = 'home' OR option_name = 'siteurl';

UPDATE wp_posts SET guid = replace(guid, 
'http://old-example.com', 
'http://new-example.com');

UPDATE wp_posts SET post_content = replace(post_content, 
'http://old-example.com', 
'http://new-example.com');

UPDATE wp_postmeta SET meta_value = replace(meta_value,
'http://old-example.com', 
'http://new-example.com');
