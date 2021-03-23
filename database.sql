DROP TABLE IF EXISTS "User";

CREATE TABLE "User" (
    id                  INTEGER,
    name                VARCHAR(50),
    username            VARCHAR(50),
    email               VARCHAR(50),
    password            VARCHAR(50),
    image               VARCHAR(50),
    banned              BOOLEAN DEFAULT FALSE,
    admin               BOOLEAN DEFAULT FALSE       

    CONSTRAINT UserPK SERIAL PRIMARY KEY (id),
    CONSTRAINT UserNameNN NOT NULL (name),
    CONSTRAINT UserUsernameNN NOT NULL (username),
    CONSTRAINT UserUsernameUK UNIQUE (username),
    CONSTRAINT UserEmailNN NOT NULL (email),
    CONSTRAINT UserEmailUK UNIQUE (email),
    CONSTRAINT UserPasswordNN NOT NULL (password),
    CONSTRAINT UserImageNN NOT NULL (image),
    CONSTRAINT UserBannedNN NOT NULL (banned),
    CONSTRAINT UserAdminNN NOT NULL (admin)
);


DROP TABLE IF EXISTS FavouriteSeller;

CREATE TABLE FavouriteSeller (
    user1ID                 INTEGER,
    user2ID                 INTEGER,

    CONSTRAINT FavouriteSellerPK SERIAL PRIMARY KEY (user1ID, user2ID),
    CONSTRAINT FavouriteSellerUser1FK FOREIGN KEY (user1ID) REFERENCES "User" ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FavouriteSellerUser2FK FOREIGN KEY (user2ID) REFERENCES "User" ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS FavouriteAuction;

CREATE TABLE FavouriteAuction (
    userID                 INTEGER,
    auctionID              INTEGER,

    CONSTRAINT FavouriteAuctionPK SERIAL PRIMARY KEY (userID,auctionID),
    CONSTRAINT FavouriteAuctionUserFK FOREIGN KEY (userID) REFERENCES "User" ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FavouriteAutionAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS HelpMessage;

CREATE TABLE HelpMessage (
    id                      INTEGER,
    text                    VARCHAR(50),
    dateHour                DATETIME DEFAULT now(),
    read                    BOOLEAN DEFAULT FALSE,
    senderID                INTEGER,
    recipientID             INTEGER,
    
    CONSTRAINT HelpMessagePK SERIAL PRIMARY KEY (id),
    CONSTRAINT HelpMessageTextNN NOT NULL (text),
    CONSTRAINT HelpMessageDateNN NOT NULL (dateHour),
    CONSTRAINT HelpMessageDateLT CHECK (dateHour <= now()),
    CONSTRAINT HelpMessageReadNN NOT NULL (read),
    CONSTRAINT HelpMessageSenderNN NOT NULL (senderID),
    CONSTRAINT HelpMessageSenderFK FOREIGN KEY (senderID) REFERENCES "User" ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT HelpMessageRecipientNN NOT NULL (recipientID),
    CONSTRAINT HelpMessageRecipientFK FOREIGN KEY (recipientID) REFERENCES "User" ON UPDATE CASCADE ON DELETE SET NULL
);


DROP TABLE IF EXISTS Rating;

CREATE TABLE Rating (
    auctionID               INTEGER,
    winnerID                INTEGER,
    value                   INTEGER,
    dateHour                DATETIME DEFAULT now(),
    comment                 VARCHAR(50),

    CONSTRAINT RatingPK SERIAL PRIMARY KEY (auctionID),
    CONSTRAINT RatingAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT RatingWinnerNN NOT NULL (winnerID),
    CONSTRAINT RatingWinnerFK FOREIGN KEY (winnerID) REFERENCES "User" ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT RatingValueNN NOT NULL (value),
    CONSTRAINT RatingValueHT CHECK (value >= 1),
    CONSTRAINT RatingValueLT CHECK (value <= 5),
    CONSTRAINT RatingDateNN NOT NULL (dateHour),
    CONSTRAINT RatingDateLT CHECK (dateHour <= now()),
    CONSTRAINT RatingCommentNN NOT NULL (comment)
);


DROP TABLE IF EXISTS Report;

CREATE TABLE Report(
    id                        INTEGER,
    reason                    VARCHAR(50),
    dateHour                  DATETIME DEFAULT now(),
    reporterID                INTEGER,
    locationAuctionID         INTEGER,
    locationCommentID         INTEGER,
    locationRegisteredID      INTEGER,
    stateType                 State DEFAULT "Waiting",

    CONSTRAINT ReportPK SERIAL PRIMARY KEY (id),
    CONSTRAINT ReportReasonNN NOT NULL (reason),
    CONSTRAINT ReportDateNN NOT NULL (dateHour),
    CONSTRAINT ReportReporterNN NOT NULL (reporterID),
    CONSTRAINT ReportReporterFK FOREIGN KEY (reporterID) REFERENCES "User" ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT ReportExclusiveORLocation CHECK (
        1 = (
            CASE WHEN locationAuctionID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN locationCommentID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN locationRegisteredID IS NOT NULL THEN 1 ELSE 0 END
        )
    ),
    CONSTRAINT ReportLocationAuctionFK FOREIGN KEY (locationAuctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ReportLocationCommentFK FOREIGN KEY (locationCommentID) REFERENCES Comment ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ReportLocationRegisteredFK FOREIGN KEY (locationRegisteredID) REFERENCES "User" ON UPDATE CASCADE ON DELETE CASCADE,
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
    startDate                DATETIME DEFAULT now(),
    finalDate                DATETIME,
    suspend                  BOOLEAN DEFAULT FALSE,
    buyNow                   DECIMAL,
    scaleType                Scale,
    brandID                  INTEGER,
    colourID                 INTEGER,
    sellerID                 INTEGER,

    CONSTRAINT AuctionPK SERIAL PRIMARY KEY (id),
    CONSTRAINT AuctionTitleNN NOT NULL(title),
    CONSTRAINT AuctionStartingPriceNN NOT NULL(startingPrice),
    CONSTRAINT AuctionStartingPriceCK CHECK(startingPrice >= 1),
    CONSTRAINT AuctionStartDateNN NOT NULL(startDate),
    CONSTRAINT AuctionStartDateCK CHECK(startDate >= now()),
    CONSTRAINT AuctionFinalDateNN NOT NULL(finalDate),
    CONSTRAINT AuctionStartDateCK CHECK(finalDate >= startDate),
    CONSTRAINT AuctionSuspendNN NOT NULL(suspend),
    CONSTRAINT AuctionBuyNowCK CHECK (buyNow IS NULL or (buyNow IS NOT NULL and buyNow > startingPrice)),
    CONSTRAINT AuctionScaleTypeNN NOT NULL(scaleType),
    CONSTRAINT AuctionBrandNN NOT NULL (brandID),
    CONSTRAINT AuctionBrandFK FOREIGN KEY (brandID) REFERENCES Brand ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT AuctionColourNN NOT NULL (colourID),
    CONSTRAINT AuctionColourFK FOREIGN KEY (colourID) REFERENCES Colour ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT AuctionSellerNN NOT NULL (sellerID),
    CONSTRAINT AuctionSellerFK FOREIGN KEY (sellerID) REFERENCES "User" ON UPDATE CASCADE ON DELETE RESTRICT
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
    auctionID               INTEGER,

    CONSTRAINT ImagePK SERIAL PRIMARY KEY (id),
    CONSTRAINT ImageUrlNN NOT NULL (url),
    CONSTRAINT ImageUrlUK UNIQUE (url),
    CONSTRAINT ImageAuctionNN NOT NULL (auctionID),
    CONSTRAINT ImageAuctionFK FOREIGN KEY (auctionID) REFERENCES (Auction) ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Colour;

CREATE TABLE Colour (
    id                      INTEGER,
    name                    VARCHAR(50),

    CONSTRAINT ColourPK SERIAL PRIMARY KEY (id),
    CONSTRAINT ColourNameNN NOT NULL (name),
    CONSTRAINT ColourNameUK UNIQUE (name)

);


DROP TABLE IF EXISTS Brand;

CREATE TABLE Brand (
    id                      INTEGER,
    name                    VARCHAR(50),

    CONSTRAINT BrandPK SERIAL PRIMARY KEY (id),
    CONSTRAINT BrandNameNN NOT NULL (name),
    CONSTRAINT BrandNameUK UNIQUE (name)

);


DROP TABLE IF EXISTS Bid;

CREATE TABLE Bid (
    id                      INTEGER,
    value                   DECIMAL,
    dateHour                DATETIME DEFAULT now(),
    authorID                INTEGER,
    auctionID               INTEGER,

    CONSTRAINT BidPK SERIAL PRIMARY KEY (id),
    CONSTRAINT BidValueNN NOT NULL (value),
    CONSTRAINT BidDateNN NOT NULL (dateHour),
    CONSTRAINT BidDateCK CHECK(dateHour <= now()),
    CONSTRAINT BidAuthorNN NOT NULL (authorID),
    CONSTRAINT BidAuthorFK FOREIGN KEY (authorID) REFERENCES "User" ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT BidAuctionNN NOT NULL (auctionID),
    CONSTRAINT BidAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE RESTRICT
);


DROP TABLE IF EXISTS Comment;

CREATE TABLE Comment (
    id                      INTEGER,
    text                    VARCHAR(50),
    dateHour                DATETIME DEFAULT now(),
    authorID                INTEGER,
    auctionID               INTEGER,
    
    CONSTRAINT CommentPK SERIAL PRIMARY KEY (id),
    CONSTRAINT CommentTextNN NOT NULL (text),
    CONSTRAINT CommentDateNN NOT NULL (dateHour),
    CONSTRAINT CommentDateLT CHECK (dateHour <= now()),
    CONSTRAINT CommentAuthorNN NOT NULL (authorID),
    CONSTRAINT CommentAuthorFK FOREIGN KEY (authorID) REFERENCES "User" ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT CommentAuctionNN NOT NULL (auctionID),
    CONSTRAINT CommentAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE
);


DROP TABLE IF EXISTS Notification;

CREATE TABLE Notification (
    id                      INTEGER,
    text                    VARCHAR(50),
    viewed                  BOOLEAN DEFAULT FALSE,
    dateHour                DATETIME DEFAULT now(),
    recipientID             INTEGER,
    contextAuctionID        INTEGER,
    contextRatingID         INTEGER,
    contextHelpMessageID    INTEGER,
    contextRegisteredID     INTEGER,
    contextBidID            INTEGER,
    contextCommentID        INTEGER,

    CONSTRAINT NotificationPK SERIAL PRIMARY KEY (id),
    CONSTRAINT NotificationTextNN NOT NULL (text),
    CONSTRAINT NotificationViewedNN NOT NULL (viewed),
    CONSTRAINT NotificationDateNN NOT NULL (dateHour),
    CONSTRAINT NotificationDateLT CHECK (dateHour <= now()),
    CONSTRAINT NotificationRecipientNN NOT NULL (recipientID),
    CONSTRAINT NotificationExclusiveORContext CHECK (
        1 = (
            CASE WHEN contextAuctionID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextRatingID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextHelpMessageID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextRegisteredID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextBidID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextCommentID IS NOT NULL THEN 1 ELSE 0 END
        )
    ),
    CONSTRAINT NotificationContextAuctionFK FOREIGN KEY (contextAuctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextRatingFK FOREIGN KEY (contextRatingID) REFERENCES Rating ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextHelpMessageFK FOREIGN KEY (contextHelpMessageID) REFERENCES HelpMessage ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextRegisteredFK FOREIGN KEY (contextRegisteredID) REFERENCES "User" ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextBidFK FOREIGN KEY (contextBidID) REFERENCES Bid ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextCommentFK FOREIGN KEY (contextCommentID) REFERENCES Comment ON UPDATE CASCADE ON DELETE CASCADE
);