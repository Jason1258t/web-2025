-- Insert posts data
INSERT INTO post (
        id,
        description,
        user_id,
        likes_count,
        created_at
    )
VALUES (
        1,
        'Так красиво сегодня на улице! Настоящая зима)) Вспоминается Бродский: «Поздно ночью, в уснувшей долине, на самом дне, в городке, занесенном снегом по ручку двери...»',
        1,
        203,
        FROM_UNIXTIME(1234123727)
    ),
    (2,  NULL, 2, 145, FROM_UNIXTIME(1234223827)),
    (
        3,
        'Люблю вечерний свет в городе. Всё кажется таким тёплым и спокойным.',
        1,
        321,
        FROM_UNIXTIME(1234323927)
    ),
    (4, NULL, 2, 87, FROM_UNIXTIME(1234424027)),
    (
        5,
        'Утренний кофе и немного книг — лучшее начало выходного ☕📖',
        1,
        405,
        FROM_UNIXTIME(1234524127)
    ),
    (
        6,
        'Немного уюта в пасмурный день. Включила плейлист дождя и просто отдыхаю.',
        2,
        192,
        FROM_UNIXTIME(1234624227)
    ),
    (7, NULL, 1, 274, FROM_UNIXTIME(1234724327)),
    (
        8,
        'Поймал этот кадр случайно — удивительно, как природа умеет удивлять 🌄',
        2,
        359,
        FROM_UNIXTIME(1234824427)
    );
-- Insert post images
INSERT INTO post_image (post_id, image_path, sort_order, created_at)
VALUES (
        1,
        '../images/mock/postPick1.jpg',
        0,
        FROM_UNIXTIME(1234123727)
    ),
    (
        2,
        '../images/mock/postPick2.jpg',
        0,
        FROM_UNIXTIME(1234223827)
    ),

    (
        1,
        '../images/mock/postPick2.jpg',
        0,
        FROM_UNIXTIME(1234223827)
    ),
    (
        3,
        '../images/mock/postPick3.jpg',
        0,
        FROM_UNIXTIME(1234323927)
    ),

    (
        2,
        '../images/mock/postPick3.jpg',
        0,
        FROM_UNIXTIME(1234323927)
    ),
    (
        4,
        '../images/mock/postPick4.jpg',
        0,
        FROM_UNIXTIME(1234424027)
    ),

    (
        2,
        '../images/mock/postPick4.jpg',
        0,
        FROM_UNIXTIME(1234424027)
    ),
    (
        5,
        '../images/mock/postPick5.jpg',
        0,
        FROM_UNIXTIME(1234524127)
    ),
    (
        6,
        '../images/mock/postPick6.jpg',
        0,
        FROM_UNIXTIME(1234624227)
    ),
    (
        7,
        '../images/mock/postPick7.jpg',
        0,
        FROM_UNIXTIME(1234724327)
    ),
    (
        8,
        '../images/mock/postPick8.jpg',
        0,
        FROM_UNIXTIME(1234824427)
    );