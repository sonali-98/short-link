CREATE TABLE users(
    user_id SERIAL PRIMARY KEY,
   email VARCHAR NOT NULL,
   password VARCHAR NOT NULL
);



CREATE TABLE links(
    link_id SERIAL PRIMARY KEY,
    user_id int REFERENCES users (user_id),
   old_link VARCHAR NOT NULL,
   new_link VARCHAR NOT NULL
);



CREATE TABLE views(
    view_id SERIAL PRIMARY KEY,
    link_id int REFERENCES links (link_id),
   	view_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

