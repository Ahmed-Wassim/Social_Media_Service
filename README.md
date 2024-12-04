
# Social Media Service API Documentation

This project implements a social media service using Laravel, where users can post tweets, interact with other users' tweets, and manage their social connections.

## Advanced Features
### Macros For Generate Generic Response (success, error), Generic Exception to handle Not Found Objects.
### Gates For Simple Policy For Editing You Own Tweet and Deleting You Own Tweet.
### Polymorphic Relation For Image Class, To Support Scalability
### Resources To Wrap the Data, Control it.
### Service Class For Tweet Service.
### Cache Layer For Performance To handle Millions of Users.
### Notify User If Someone Followed using Mailgun service.
### Tweet Slug To Prevent Web Scraping.

## Postman Collection Link
https://api.postman.com/collections/29278575-e8c14625-a5c7-4af9-b4b4-5c3211275772?access_key=PMAT-01JE9RADYQFMB5A4Q8RQPR6CPM

---

## Authentication APIs

### 1. Login API
**Endpoint:** `POST /api/login`  
**Description:** Authenticates a user using their email and password.  

**Request:**
```json
{
    "email": "user@example.com",
    "password": "Password123!"
}
```

**Validation:**
- `email`: Required, valid email format.
- `password`: Required, Common Password Validation.

**Response:**
```json
{
    "success": true,
    "data" : {data},
    "token": "user_access_token"
}
```

---

### 2. Register API
**Endpoint:** `POST /api/register`  
**Description:** Registers a new user.  

**Request:**
```json
{
    "email": "user@example.com",
    "username": "username123",
    "password": "Password123!",
    "image": "base64_encoded_image"
}
```

**Validation:**
- `email`: Required, unique, valid email format.
- `username`: Required, no spaces allowed, using Regex.
- `password`: Required, at least 8 characters, including one uppercase letter, one lowercase letter, one number, and one special character.
- `image`: Optional, must be PNG/JPG format, max size 1MB.

**Response:**
```json
{
    "success": true,
    "message": "User registered successfully."
}
```

### 2.2 Profile API
**Endpoint:** `GET /api/profile/{id}`  
**Description:** Get user profile.  

**Request:**
```json
{
    "user": {
        "id": 93,
        "username": "Ms. Katelyn Veum",
        "email": "mortimer59@example.com",
        "followers_count": 1,
        "followings_count": 0,
        "image": null
    },
    "tweets": {
        "current_page": 1,
        "data": [
            {
                "id": 22,
                "user_id": 93,
                "body": "Id beatae cupiditate quas modi aut.",
                "slug": "id-beatae-cupiditate",
                "likes_count": 0,
                "comments": [
                    {
                        "id": 85,
                        "user_id": 94,
                        "tweet_id": 22,
                        "body": "Non et dolor corrupti alias ea minima.",
                        "user": {
                            "id": 94,
                            "username": "Rosie Doyle",
                            "email": "acasper@example.com",
                            "image": null
                        }
                    },
                ]
            },
        ],
        "first_page_url": "https://social_media_service.test/api/profile/93?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "https://social_media_service.test/api/profile/93?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "https://social_media_service.test/api/profile/93?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "https://social_media_service.test/api/profile/93",
        "per_page": 8,
        "prev_page_url": null,
        "to": 3,
        "total": 3
    },
    "followersCount": 1,
    "followingsCount": 0
}
```

**Validation:**
- `email`: Required, unique, valid email format.
- `username`: Required, no spaces allowed, using Regex.
- `password`: Required, at least 8 characters, including one uppercase letter, one lowercase letter, one number, and one special character.
- `image`: Optional, must be PNG/JPG format, max size 1MB.

**Response:**
```json
{
    "success": true,
    "message": "User registered successfully."
}
```


---

## Tweet APIs

### 3. Create Tweet
**Endpoint:** `POST /api/tweets`  
**Description:** Allows a user to create a tweet.

**Request:**
```json
{
    "body": "This is my first tweet!"
}
```

**Validation:**
- `body`: Required, maximum 140 characters.

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 20,
        "body": "Totam ut illum dolorem est qui error.",
        "slug": "totam-ut-illum-dolorem",
        "created_at": "1 hour ago",
        "user": {
            "id": 80,
            "username": "Dr. Anibal Ferry MD",
            "email": "feeney.jon@example.net",
            "image": null
        },
        "comments": [
            {
                "id": 77,
                "user": {
                    "id": 85,
                    "username": "Dr. Monserrate Kulas DVM",
                    "email": "darrion38@example.com",
                    "image": null
                },
                "body": "Et non eum debitis.",
                "created_at": "1 hour ago"
            },
        ]
    }
}
```

---

### 4. Edit Tweet
**Endpoint:** `PUT /api/tweets/{slug}`  
**Description:** Allows a user to edit their own tweet.

**Request:**
```json
{
    "body": "This is my updated tweet!"
}
```

**Validation:**
- `body`: Required, maximum 140 characters.

**Response:**
```json
{
    "success": true,
    "message": "Tweet updated successfully."
}
```

---

### 5. Interact with Tweet (Like/Comment)
seprate the like, unlike end points (rest rules (each action has only end point))
**Endpoints:**  
- Like a Tweet: `POST /api/tweets/{slug}/like`  
- Unlike a Tweet: `POST /api/tweets/{slug}/unlike`
  
- Comment on a Tweet: `POST /api/tweets/{slug}/comment`  

**Request for Comment:**
```json
{
    "body": "Great tweet!"
}
```

**Validation for Comment:**
- `body`: Required.

**Response for Like:**
```json
{
    "success": true,
    "message": "Tweet liked successfully."
}
```

**Response for Comment:**
```json
{
    "success": true,
    "comment": "Comment created successfully"
}
```

---

## User Timeline APIs

### 6. Follow User
**Endpoint:** 
- `POST /api/users/{id}/follow`
- `POST /api/users/{id}/unfollow`

**Description:** Allows a user to follow, unfollow another user.

**Response:**
```json
{
    "success": true,
    "message": "You are now following this user."
}
```

---

### 7. Get Timeline
**Endpoint:** `GET /api/timeline`  
**Description:** Retrieves tweets from users the authenticated user follows, cached and paginated.

**Response:**
```json
{
    "success": true,
    "data": {
        "tweets": [
            {
                "id": 1,
                "text": "Hello World!",
                "likes_count": 10,
                "user":{userData},
                "comments_count": 5,
                "latest_comments": [
                    {
                        "id": 1,
                        "text": "Nice tweet!",
                        "user":{userData},
                        "created_at": "6 min ago"
                    }
                ],
                "created_at": "30 min ago"
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 5
        }
    }
}
```

---

## Bonus Features

### 8. Email Notification on Follow
**Description:** Sends an email notification when a user is followed using Mailgun. (free plan so didn't work).  

---

## Database Seeders and Factories

- **User Factory**: Creates mock users with email, username, and password.
- **Tweet Factory**: Generates tweets with text limited to 140 characters.

