<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        background-color: #44008b;
        color: white;
        font-family: 'Segoe UI', sans-serif;
    }

    .post-form-container {
        background: #ff66cc;
        /* Deep purple card */
        padding: 25px;
        max-width: 700px;
        margin: 40px auto;
        border-radius: 12px;
    }

    .post-form-container h2 {
        color: #ff99cc;
        /* light pink header */
        margin-bottom: 20px;
    }

    .post-form-container input[type="text"],
    .post-form-container textarea {
        width: 100%;
        background-color: #1a0033;
        color: #fff;
        border: 1px solid #ff66cc;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 16px;
        font-size: 1rem;
    }

    .post-form-container input[type="text"]::placeholder,
    .post-form-container textarea::placeholder {
        color: #cccccc;
    }

    .form-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-buttons button {
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .form-buttons button[type="submit"] {
        background: , #ff66cc;
        color: white;
    }
</style>

<body>
    <form action="">
        <div class="post-form-container">
            <h2>Create a Post</h2>
            <form action="submit_post.php" method="POST">
                <input type="text" name="title" placeholder="Post Title" maxlength="300" required>
                <div class="form-group">
                    <label for="platform">Platform:</label>
                    <select id="platform" name="platform">
                        <option value="PC">PC</option>
                        <option value="PlayStation 5">PlayStation 5</option>
                        <option value="PlayStation 4">PlayStation 4</option>
                        <option value="Xbox Series">Xbox Series</option>
                        <option value="Xbox One">Xbox One</option>
                        <option value="Nintendo Switch">Nintendo Switch</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="review-text">Review:</label>
                    <textarea id="review-text" name="review_text" rows="4" required
                        placeholder="What'd you think..."></textarea>
                </div>


                <textarea name="body" placeholder="Post content..." rows="8" required></textarea>

                <div class="form-buttons">
                    <button type="submit">Post</button>
                </div>
            </form>
        </div>



    </form>

</body>

</html>