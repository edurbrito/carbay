PRAGMA FOREIGN_KEYS = ON;

.mode column
.headers on
.nullvalue NULL

---------------------------------------------

DROP TABLE IF EXISTS User;

CREATE TABLE User (
    id                  INTEGER,
    name                VARCHAR(50),
    username            VARCHAR(50),
    email               VARCHAR(50),
    password            VARCHAR(50),
    image               VARCHAR(50),

    CONSTRAINT UserPK PRIMARY KEY (id),
    CONSTRAINT UserNameNN NOT NULL (name),
    CONSTRAINT UserUsernameNN NOT NULL (username),
    CONSTRAINT UserUsernameUK UNIQUE (username),
    CONSTRAINT UserEmailNN NOT NULL (email),
    CONSTRAINT UserEmailUK UNIQUE (email),
    CONSTRAINT UserPasswordNN NOT NULL (password),
    CONSTRAINT UserImageNN NOT NULL (image)
);


DROP TABLE IF EXISTS Registered;

CREATE TABLE Registered (
    id                  INTEGER,
    banned              BOOLEAN DEFAULT FALSE,

    CONSTRAINT RegisteredPK PRIMARY KEY (id),
    CONSTRAINT RegisteredFK FOREIGN KEY (id) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT RegisteredBannedNN NOT NULL (banned)
);


DROP TABLE IF EXISTS FavoriteSeller;

CREATE TABLE FavoriteSeller (
    user1                 INTEGER,
    user2                 INTEGER,

    CONSTRAINT FavoriteSellerPK PRIMARY KEY (user1,user2),
    CONSTRAINT FavoriteSellerUser1FK FOREIGN KEY (user1) REFERENCES Registered ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FavoriteSellerUser2FK FOREIGN KEY (user2) REFERENCES Registered ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS FavoriteAuction;

CREATE TABLE FavoriteAuction (
    user                 INTEGER,
    auction              INTEGER,

    CONSTRAINT FavoriteAuctionPK PRIMARY KEY (user,auction),
    CONSTRAINT FavoriteAuctionUserFK FOREIGN KEY (user) REFERENCES Registered ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FavoriteAutionAuctionFK FOREIGN KEY (auction) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Admin;

CREATE TABLE Admin (
    user                  INTEGER,

    CONSTRAINT AdminPK PRIMARY KEY (user),
    CONSTRAINT AdminFK FOREIGN KEY (user) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS HelpMessage;

CREATE TABLE HelpMessage (
    id                      INTEGER,
    text                    VARCHAR(50),
    date                    DATE DEFAULT now(),
    read                    BOOLEAN DEFAULT FALSE,
    sender                  INTEGER,
    recipient               INTEGER,
    
    CONSTRAINT HelpMessagePK PRIMARY KEY (id),
    CONSTRAINT HelpMessageTextNN NOT NULL (text),
    CONSTRAINT HelpMessageDateNN NOT NULL (date),
    CONSTRAINT HelpMessageDateLT CHECK (date <= now()),
    CONSTRAINT HelpMessageReadNN NOT NULL (read),
    CONSTRAINT HelpMessageSenderNN NOT NULL (sender),
    CONSTRAINT HelpMessageSenderFK FOREIGN KEY (sender) REFERENCES User ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT HelpMessageRecipientNN NOT NULL (recipient),
    CONSTRAINT HelpMessageRecipientFK FOREIGN KEY (recipient) REFERENCES User ON UPDATE CASCADE ON DELETE SET NULL
);


DROP TABLE IF EXISTS Rating;

CREATE TABLE Rating (
    auction                 INTEGER,
    winner                  INTEGER,
    value                   INTEGER,
    date                    DATE DEFAULT now(),
    comment                 VARCHAR(50),

    CONSTRAINT RatingPK PRIMARY KEY (auction),
    CONSTRAINT RatingAuctionFK FOREIGN KEY (auction) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT RatingWinnerNN NOT NULL (winner),
    CONSTRAINT RatingWinnerFK FOREIGN KEY (winner) REFERENCES Registered ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT RatingValueNN NOT NULL (value),
    CONSTRAINT RatingValueHT CHECK (value >= 1),
    CONSTRAINT RatingValueLT CHECK (value <= 5),
    CONSTRAINT RatingDateNN NOT NULL (date),
    CONSTRAINT RatingDateLT CHECK (date <= now()),
    CONSTRAINT RatingCommentNN NOT NULL (comment)
);


DROP TABLE IF EXISTS Report;

CREATE TABLE Report(
    id                      INTEGER,
    reason                  VARCHAR(50),
    date                    DATE DEFAULT now(),
    reporter                INTEGER,
    locationAuction         INTEGER,
    locationComment         INTEGER,
    locationRegistered      INTEGER,
    stateType               State DEFAULT "Waiting",

    CONSTRAINT ReportPK PRIMARY KEY (id),
    CONSTRAINT ReportReasonNN NOT NULL (reason),
    CONSTRAINT ReportDateNN NOT NULL (date),
    CONSTRAINT ReportReporterNN NOT NULL (reporter),
    CONSTRAINT ReportReporterFK FOREIGN KEY (reporter) REFERENCES Registered ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT ReportExclusiveORLocation CHECK (
        1 = (
            CASE WHEN locationAuction IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN locationComment IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN locationRegistered IS NOT NULL THEN 1 ELSE 0 END
        )
    ),
    CONSTRAINT ReportLocationAuctionFK FOREIGN KEY (locationAuction) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ReportLocationCommentFK FOREIGN KEY (locationComment) REFERENCES Comment ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ReportLocationRegisteredFK FOREIGN KEY (locationRegistered) REFERENCES Registered ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ReportStateTypeNN NOT NULL (stateType)
);


CREATE TYPE State as ENUM (
  "Waiting",
  "Discarded",
  "Banned"
);


DROP TABLE IF EXISTS Auction;

CREATE TABLE Auction (
    id                       INTEGER,
    title                    VARCHAR(50),
    startingPrice            DECIMAL,
    startDate                DATE DEFAULT now(),
    durationDays             INTEGER,
    suspend                  BOOLEAN DEFAULT FALSE,
    buyNow                   DECIMAL,
    scaleType                Scale,
    brand                    INTEGER,
    colour                   INTEGER,
    seller                   INTEGER,

    CONSTRAINT AuctionPK PRIMARY KEY (id),
    CONSTRAINT AuctionTitleNN NOT NULL(title),
    CONSTRAINT AuctionStartingPriceNN NOT NULL(startingPrice),
    CONSTRAINT AuctionStartingPriceCK CHECK(startingPriceq >= 1),
    CONSTRAINT AuctionStartDateNN NOT NULL(startDate),
    CONSTRAINT AuctionStartDateCK CHECK(date >= now()),
    CONSTRAINT AuctionDurationDaysNN NOT NULL(durationDays),
    CONSTRAINT AuctionDurationDaysCKGT CHECK(durationDays >= 1),
    CONSTRAINT AuctionDurationDaysCKLT CHECK(durationDays <= 7),
    CONSTRAINT AuctionSuspendNN NOT NULL(suspend),
    CONSTRAINT AuctionBuyNowCK CHECK (buyNow IS NULL or (buyNow IS NOT NULL and buyNow > startingPrice)),
    CONSTRAINT AuctionScaleTypeNN NOT NULL(scaleType),
    CONSTRAINT AuctionBrandNN NOT NULL (brand),
    CONSTRAINT AuctionBrandFK FOREIGN KEY (brand) REFERENCES Brand ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT AuctionColourNN NOT NULL (colour),
    CONSTRAINT AuctionColourFK FOREIGN KEY (colour) REFERENCES Colour ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT AuctionSellerNN NOT NULL (seller),
    CONSTRAINT AuctionSellerFK FOREIGN KEY (seller) REFERENCES Registered ON UPDATE CASCADE ON DELETE RESTRICT
);


CREATE TYPE Scale as ENUM (
  "1:8",
  "1:18",
  "1:43",
  "1:64"
);


DROP TABLE IF EXISTS Image;

CREATE TABLE Image (
    id                      INTEGER,
    url                     VARCHAR(50),
    auction                 INTEGER,

    CONSTRAINT ImagePK PRIMARY KEY (id),
    CONSTRAINT ImageUrlNN NOT NULL (url),
    CONSTRAINT ImageUrlUK UNIQUE (url),
    CONSTRAINT ImageAuction NOT NULL (auction),
    CONSTRAINT ImageAuctionFK FOREIGN KEY (auction) REFERENCES (Auction) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Colour;

CREATE TABLE Colour (
    id                      INTEGER,
    name                    VARCHAR(50),

    CONSTRAINT ColourPK PRIMARY KEY (id),
    CONSTRAINT ColourNameNN NOT NULL (name),
    CONSTRAINT ColourNameUK UNIQUE (name)

);


DROP TABLE IF EXISTS Brand;

CREATE TABLE Brand (
    id                      INTEGER,
    name                    VARCHAR(50),

    CONSTRAINT BrandPK PRIMARY KEY (id),
    CONSTRAINT BrandNameNN NOT NULL (name),
    CONSTRAINT BrandNameUK UNIQUE (name)

);


DROP TABLE IF EXISTS Bid;

CREATE TABLE Bid (
    id                      INTEGER,
    value                   DECIMAL,
    date                    DATE DEFAULT now(),
    author                  INTEGER,
    auction                 INTEGER,

    CONSTRAINT BidPK PRIMARY KEY (id),
    CONSTRAINT BidValueNN NOT NULL (value),
    CONSTRAINT BidDateNN NOT NULL (date),
    CONSTRAINT BidDateCK CHECK(date <= now()),
    CONSTRAINT BidAuthorNN NOT NULL (author),
    CONSTRAINT BidAuthorFK FOREIGN KEY (author) REFERENCES registered ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT BidAuctionNN NOT NULL (auction),
    CONSTRAINT BidAuctionFK FOREIGN KEY (auction) REFERENCES auction ON UPDATE CASCADE ON DELETE RESTRICT
);


DROP TABLE IF EXISTS Comment;

CREATE TABLE Comment (
    id                      INTEGER,
    text                    VARCHAR(50),
    date                    DATE DEFAULT now(),
    author                  INTEGER,
    auction                 INTEGER,
    
    CONSTRAINT CommentPK PRIMARY KEY (id),
    CONSTRAINT CommentTextNN NOT NULL (text),
    CONSTRAINT CommentDateNN NOT NULL (date),
    CONSTRAINT CommentDateLT CHECK (date <= now()),
    CONSTRAINT CommentAuthorNN NOT NULL (author),
    CONSTRAINT CommentAuthorFK FOREIGN KEY (author) REFERENCES Registered ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT CommentAuctionNN NOT NULL (auction),
    CONSTRAINT CommentAuctionFK FOREIGN KEY (auction) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Notification;

CREATE TABLE Notification (
    id                      INTEGER,
    text                    VARCHAR(50),
    viewed                  BOOLEAN DEFAULT FALSE,
    date                    DATE DEFAULT now(),
    recipient               INTEGER,
    contextAuction          INTEGER,
    contextRating           INTEGER,
    contextHelpMessage      INTEGER,
    contextRegistered       INTEGER,
    contextBid              INTEGER,
    contextComment          INTEGER,

    CONSTRAINT NotificationPK PRIMARY KEY (id),
    CONSTRAINT NotificationTextNN NOT NULL (text),
    CONSTRAINT NotificationViewedNN NOT NULL (viewed),
    CONSTRAINT NotificationDateNN NOT NULL (date),
    CONSTRAINT NotificationDateLT CHECK (date <= now()),
    CONSTRAINT NotificationRecipientNN NOT NULL (recipient),
    CONSTRAINT NotificationExclusiveORContext CHECK (
        1 = (
            CASE WHEN contextAuction IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextRating IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextHelpMessage IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextRegistered IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextBid IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextComment IS NOT NULL THEN 1 ELSE 0 END
        )
    ),
    CONSTRAINT NotificationContextAuctionFK FOREIGN KEY (contextAuction) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextRatingFK FOREIGN KEY (contextRating) REFERENCES Rating ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextHelpMessageFK FOREIGN KEY (contextHelpMessage) REFERENCES HelpMessage ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextRegisteredFK FOREIGN KEY (contextRegistered) REFERENCES Registered ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextBidFK FOREIGN KEY (contextBid) REFERENCES Bid ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextCommentFK FOREIGN KEY (contextComment) REFERENCES Comment ON UPDATE CASCADE ON DELETE CASCADE
);