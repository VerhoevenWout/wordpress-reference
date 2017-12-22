UPDATE 
    wp_posts
SET 
    post_type = REPLACE(post_type,'venues','plaats')
WHERE 
    post_type LIKE '%venues%'