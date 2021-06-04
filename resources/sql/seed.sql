DROP TABLE IF EXISTS "password_resets" CASCADE;
DROP TABLE IF EXISTS Rating CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS Image CASCADE;
DROP TABLE IF EXISTS Auction CASCADE;
DROP TABLE IF EXISTS Brand CASCADE;
DROP TABLE IF EXISTS Colour CASCADE;
DROP TABLE IF EXISTS FavouriteSeller CASCADE;
DROP TABLE IF EXISTS FavouriteAuction CASCADE;
DROP TABLE IF EXISTS "user" CASCADE;
DROP TABLE IF EXISTS HelpMessage CASCADE;
DROP TABLE IF EXISTS Bid CASCADE;
DROP TABLE IF EXISTS Notification CASCADE;

DROP TYPE IF EXISTS Scale CASCADE;
DROP TYPE IF EXISTS State CASCADE;

DROP TRIGGER IF EXISTS bid_rules ON Bid;
DROP TRIGGER IF EXISTS update_auction ON Bid;
DROP TRIGGER IF EXISTS help_message_types ON HelpMessage;
DROP TRIGGER IF EXISTS rating_rules ON Rating;
DROP TRIGGER IF EXISTS delete_rules ON "user";
DROP TRIGGER IF EXISTS notify_rating ON Rating;
DROP TRIGGER IF EXISTS notify_help_message ON HelpMessage;
DROP TRIGGER IF EXISTS notify_favorite_sellers ON Auction;
DROP TRIGGER IF EXISTS fts_auction_insert ON Auction;
DROP TRIGGER IF EXISTS fts_auction_update ON Auction;

DROP FUNCTION IF EXISTS bid_rules() CASCADE;
DROP FUNCTION IF EXISTS update_auction() CASCADE;
DROP FUNCTION IF EXISTS help_message_types() CASCADE;
DROP FUNCTION IF EXISTS rating_rules() CASCADE;
DROP FUNCTION IF EXISTS delete_rules() CASCADE;
DROP FUNCTION IF EXISTS notify_rating() CASCADE;
DROP FUNCTION IF EXISTS notify_help_message() CASCADE;
DROP FUNCTION IF EXISTS notify_favorite_sellers() CASCADE;
DROP FUNCTION IF EXISTS auction_search_update() CASCADE;


CREATE TABLE "password_resets" (
    email               character varying(255) NOT NULL,
    token               character varying(255) NOT NULL,
    created_at          timestamp(0) without time zone NOT NULL
);

CREATE INDEX password_resets_email_index ON "password_resets" USING btree (email);


CREATE TABLE "user" (
    id                  SERIAL,
    name                VARCHAR(300) NOT NULL,
    username            VARCHAR(300) NOT NULL,
    email               VARCHAR(300) NOT NULL,
    password            VARCHAR(300) NOT NULL,
    image               VARCHAR(300) DEFAULT '/images/default-non-user-no-photo.jpg' NOT NULL,
    banned              BOOLEAN DEFAULT FALSE NOT NULL,
    admin               BOOLEAN DEFAULT FALSE NOT NULL,
    remember_token      VARCHAR(300),

    CONSTRAINT UserPK PRIMARY KEY (id),
    CONSTRAINT UserUsernameUK UNIQUE (username),
    CONSTRAINT UserEmailUK UNIQUE (email)
);


CREATE TYPE Scale as ENUM (
  '1:8',
  '1:18',
  '1:43',
  '1:64'
);


CREATE TABLE Colour (
    id                      SERIAL,
    name                    VARCHAR(300) NOT NULL,

    CONSTRAINT ColourPK PRIMARY KEY (id),
    CONSTRAINT ColourNameUK UNIQUE (name)

);


CREATE TABLE Brand (
    id                      SERIAL,
    name                    VARCHAR(300) NOT NULL,

    CONSTRAINT BrandPK PRIMARY KEY (id),
    CONSTRAINT BrandNameUK UNIQUE (name)

);


CREATE TABLE Auction (
    id                       SERIAL,
    title                    VARCHAR(300) NOT NULL,
    description              VARCHAR(1000) NOT NULL,
    startingPrice            DECIMAL NOT NULL,
    highestbid               DECIMAL DEFAULT NULL,
    startDate                TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    finalDate                TIMESTAMP WITH TIME zone NOT NULL,
    suspend                  BOOLEAN DEFAULT FALSE NOT NULL,
    buyNow                   DECIMAL,
    scaleType                Scale NOT NULL,
    brandID                  INTEGER NOT NULL,
    colourID                 INTEGER NOT NULL,
    sellerID                 INTEGER,
    search                   TSVECTOR,
    
    CONSTRAINT AuctionPK PRIMARY KEY (id),
    CONSTRAINT AuctionStartingPriceCK CHECK(startingPrice >= 1),
    -- CONSTRAINT AuctionStartDateCK CHECK(startDate >= now()),
    CONSTRAINT AuctionFinalDateCK CHECK(finalDate >= startDate),
    CONSTRAINT AuctionBuyNowCK CHECK (buyNow IS NULL or (buyNow IS NOT NULL and buyNow > startingPrice)),
    CONSTRAINT AuctionBrandFK FOREIGN KEY (brandID) REFERENCES Brand ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT AuctionColourFK FOREIGN KEY (colourID) REFERENCES Colour ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT AuctionSellerFK FOREIGN KEY (sellerID) REFERENCES "user" ON UPDATE CASCADE ON DELETE SET NULL
);


CREATE TABLE Image (
    id                      SERIAL,
    url                     VARCHAR(300) NOT NULL,
    auctionID               INTEGER NOT NULL,

    CONSTRAINT ImagePK PRIMARY KEY (id),
    CONSTRAINT ImageUrlUK UNIQUE (url),
    CONSTRAINT ImageAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE FavouriteSeller (
    id                      SERIAL, 
    user1ID                 SERIAL,
    user2ID                 SERIAL,

    CONSTRAINT FavouriteSellerPK PRIMARY KEY (id),
    CONSTRAINT FavouriteSellerUK UNIQUE (user1ID, user2ID),
    CONSTRAINT FavouriteSellerUser1FK FOREIGN KEY (user1ID) REFERENCES "user" ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FavouriteSellerUser2FK FOREIGN KEY (user2ID) REFERENCES "user" ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE FavouriteAuction (
    id                     SERIAL,
    userID                 SERIAL,
    auctionID              SERIAL,

    CONSTRAINT FavouriteAuctionPK PRIMARY KEY (id),
    CONSTRAINT FavouriteAuctionUK UNIQUE (userID, auctionID),
    CONSTRAINT FavouriteAuctionUserFK FOREIGN KEY (userID) REFERENCES "user" ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FavouriteAutionAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE HelpMessage (
    id                      SERIAL,
    text                    VARCHAR(300) NOT NULL,
    dateHour                TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    read                    BOOLEAN DEFAULT FALSE NOT NULL,
    senderID                INTEGER,
    recipientID             INTEGER,
    
    CONSTRAINT HelpMessagePK PRIMARY KEY (id),
    CONSTRAINT HelpMessageDateLT CHECK (dateHour <= now()),
    CONSTRAINT HelpMessageSenderFK FOREIGN KEY (senderID) REFERENCES "user" ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT HelpMessageRecipientFK FOREIGN KEY (recipientID) REFERENCES "user" ON UPDATE CASCADE ON DELETE SET NULL
);


CREATE TABLE Rating (
    id                      SERIAL,
    auctionID               SERIAL,
    winnerID                INTEGER,
    value                   INTEGER NOT NULL,
    dateHour                TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    comment                 VARCHAR(300) NOT NULL,

    CONSTRAINT RatingPK PRIMARY KEY (id),
    CONSTRAINT RatingUK UNIQUE (auctionID),
    CONSTRAINT RatingAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT RatingWinnerFK FOREIGN KEY (winnerID) REFERENCES "user" ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT RatingValueHT CHECK (value >= 1),
    CONSTRAINT RatingValueLT CHECK (value <= 5),
    CONSTRAINT RatingDateLT CHECK (dateHour <= now())
);


CREATE TYPE State as ENUM (
  'Waiting',
  'Discarded',
  'Banned'
);


CREATE TABLE Comment (
    id                      SERIAL,
    text                    VARCHAR(300) NOT NULL,
    dateHour                TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    authorID                INTEGER NOT NULL,
    auctionID               INTEGER NOT NULL,
    
    CONSTRAINT CommentPK PRIMARY KEY (id),
    CONSTRAINT CommentDateLT CHECK (dateHour <= now()),
    CONSTRAINT CommentAuthorFK FOREIGN KEY (authorID) REFERENCES "user" ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT CommentAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE Report(
    id                        SERIAL,
    reason                    VARCHAR(300) NOT NULL,
    dateHour                  TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    reporterID                INTEGER,
    locationAuctionID         INTEGER DEFAULT NULL,
    locationCommentID         INTEGER DEFAULT NULL,
    locationRegisteredID      INTEGER DEFAULT NULL,
    stateType                 State DEFAULT 'Waiting' NOT NULL,
    reportedID                INTEGER,

    CONSTRAINT ReportPK PRIMARY KEY (id),
    CONSTRAINT ReportReporterFK FOREIGN KEY (reporterID) REFERENCES "user" ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT ReportReportedFK FOREIGN KEY (reportedID) REFERENCES "user" ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT ReportExclusiveORLocation CHECK (
        1 = (
            CASE WHEN locationAuctionID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN locationCommentID IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN locationRegisteredID IS NOT NULL THEN 1 ELSE 0 END
        )
    ),
    CONSTRAINT ReportLocationAuctionFK FOREIGN KEY (locationAuctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ReportLocationCommentFK FOREIGN KEY (locationCommentID) REFERENCES Comment ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ReportLocationRegisteredFK FOREIGN KEY (locationRegisteredID) REFERENCES "user" ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE Bid (
    id                      SERIAL,
    value                   DECIMAL NOT NULL,
    dateHour                TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    authorID                INTEGER,
    auctionID               INTEGER NOT NULL,

    CONSTRAINT BidPK PRIMARY KEY (id),
    CONSTRAINT BidDateCK CHECK(dateHour <= now()),
    CONSTRAINT BidAuthorFK FOREIGN KEY (authorID) REFERENCES "user" ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT BidAuctionFK FOREIGN KEY (auctionID) REFERENCES Auction ON UPDATE CASCADE ON DELETE RESTRICT
);


CREATE TABLE Notification (
    id                      SERIAL,
    viewed                  BOOLEAN DEFAULT FALSE NOT NULL,
    deleted                 BOOLEAN DEFAULT FALSE NOT NULL,
    dateHour                TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
    recipientID             INTEGER NOT NULL,
    contextRating           INTEGER DEFAULT NULL,
    contextRate             INTEGER DEFAULT NULL,
    contextHelpMessage      INTEGER DEFAULT NULL,
    contextFavSeller        INTEGER DEFAULT NULL,
    contextBid              INTEGER DEFAULT NULL,
    contextFavAuction       INTEGER DEFAULT NULL,

    CONSTRAINT NotificationPK PRIMARY KEY (id),
    CONSTRAINT NotificationUK1 UNIQUE (recipientID, contextRating),
    CONSTRAINT NotificationUK2 UNIQUE (recipientID, contextRate),
    CONSTRAINT NotificationUK3 UNIQUE (recipientID, contextFavSeller),
    CONSTRAINT NotificationUK4 UNIQUE (recipientID, contextFavAuction),
    CONSTRAINT NotificationDateLT CHECK (dateHour <= now()),
    CONSTRAINT NotificationExclusiveORContext CHECK (
        1 = (
            CASE WHEN contextRating IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextRate IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextHelpMessage IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextFavSeller IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextBid IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN contextFavAuction IS NOT NULL THEN 1 ELSE 0 END
        )
    ),
    CONSTRAINT NotificationRecipientIDFK FOREIGN KEY (recipientID) REFERENCES "user" ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextRatingFK FOREIGN KEY (contextRating) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextRateFK FOREIGN KEY (contextRate) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextHelpMessageFK FOREIGN KEY (contextHelpMessage) REFERENCES HelpMessage ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextFavSellerFK FOREIGN KEY (contextFavSeller) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextBidFK FOREIGN KEY (contextBid) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT NotificationContextFavAuctionFK FOREIGN KEY (contextFavAuction) REFERENCES Auction ON UPDATE CASCADE ON DELETE CASCADE
);


------------------------------INDEXES------------------------------


CREATE INDEX auction_date ON auction USING btree (finalDate);

CREATE INDEX auction_buyNow ON auction USING btree (buyNow);

CREATE INDEX comment_auction ON comment USING hash (auctionID);

CREATE INDEX bid_value ON bid USING btree (auctionID, value);

CREATE INDEX auction_search ON auction USING gist (search);


------------------------------FUNCTIONS------------------------------


CREATE FUNCTION bid_rules() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS 
        (SELECT * 
        FROM bid 
        WHERE NEW.auctionID = bid.auctionID AND bid.value >= NEW.value)
    THEN 
    RAISE EXCEPTION 'A new bid must be higher than any other bids of the auction.';
    END IF;
    IF EXISTS 
        (SELECT *            
        FROM (SELECT startingPrice 
            FROM auction 
            WHERE auction.id = NEW.auctionID) AS ST  
        WHERE ST.startingPrice > NEW.value)
    THEN 
    RAISE EXCEPTION 'A new bid must be higher than the starting price.';
    END IF;
    IF EXISTS 
        (SELECT * 
        FROM auction 
        WHERE auction.id = NEW.auctionID AND auction.sellerID = NEW.authorID)
    THEN 
    RAISE EXCEPTION 'The author of a new bid must not be the auction seller.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE FUNCTION update_auction() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE auction SET highestbid = NEW.value WHERE auction.id = NEW.auctionID;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION help_message_types() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.senderID = NEW.recipientID OR EXISTS 
        (SELECT u1.admin , u2.admin 
        FROM "user" AS u1, "user" AS u2
        WHERE u1.id = NEW.senderID AND u2.id = NEW.recipientID AND u1.admin = u2.admin)
    THEN 
    RAISE EXCEPTION 'In a HelpMessage, the Sender must be of a different type of the Recipient.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 

CREATE FUNCTION rating_rules() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS 
        (SELECT T.authorID FROM (SELECT MAX(value) AS value, bid.auctionID, bid.authorID 
                FROM bid 
                GROUP BY bid.authorID, bid.auctionID
                HAVING bid.auctionID = NEW.auctionID
				ORDER BY value DESC
				LIMIT 1) AS T
        WHERE T.authorID = NEW.winnerID)
    THEN 
    RAISE EXCEPTION 'The registered user can only give a rating to an auction he won.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 

CREATE FUNCTION delete_rules() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS 
        (SELECT auction.id FROM auction WHERE OLD.id = auction.sellerID AND finalDate > NOW())
    THEN 
    RAISE EXCEPTION 'A user can only delete its account if there are no active auctions where he is the seller.';
    END IF;
    IF EXISTS 
        (SELECT bid.id, bid.value, bid.authorID FROM bid 
        WHERE bid.id IN 
            (SELECT MAX(bid.id) 
            FROM bid GROUP BY bid.auctionID) 
        AND bid.authorID = OLD.id AND bid.auctionID in (SELECT auction.id FROM auction WHERE finalDate > NOW()))
    THEN 
    RAISE EXCEPTION 'A user can only delete its account if he is not the author of any highest bid.';
    END IF;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;
 

CREATE FUNCTION notify_rating() RETURNS TRIGGER AS 
$BODY$
BEGIN
    INSERT INTO notification (recipientId, contextRating)
    VALUES (
        (SELECT sellerID FROM auction WHERE auction.id = NEW.auctionID),
        NEW.auctionID
    );
    RETURN NEW;
END
$BODY$
LANGUAGE 'plpgsql';


CREATE FUNCTION notify_help_message() RETURNS TRIGGER AS 
$BODY$
BEGIN
    INSERT INTO notification (recipientId, contextHelpMessage)
    VALUES (NEW.recipientID, NEW.id);
    RETURN NEW;
END
$BODY$ 
LANGUAGE 'plpgsql';


CREATE FUNCTION notify_favorite_sellers() RETURNS TRIGGER AS 
$BODY$
BEGIN
    INSERT INTO notification (recipientId, contextFavSeller) 
    SELECT user1ID , NEW.id 
        FROM FavouriteSeller 
        WHERE FavouriteSeller.user2ID = NEW.sellerID;
    RETURN NEW;
END
$BODY$ 
LANGUAGE 'plpgsql';


CREATE FUNCTION auction_search_update() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.search =  setweight(to_tsvector('english', NEW.title), 'A') || 
            setweight(to_tsvector('english', (SELECT name FROM colour WHERE colour.id = NEW.colourID)), 'B') ||
            setweight(to_tsvector('simple', (SELECT name FROM brand WHERE brand.id = NEW.brandID)), 'B') ||
            setweight(to_tsvector('simple', (SELECT username FROM "user" WHERE "user".id = NEW.sellerID)), 'B') ||
            setweight(to_tsvector('english', NEW.description), 'C');
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF 
        NEW.title <> OLD.title OR 
        NEW.colourID <> OLD.colourID OR 
        NEW.brandID <> OLD.brandID OR 
        NEW.sellerID <> OLD.sellerID OR 
        NEW.description <> OLD.description 
        THEN
            NEW.search =  setweight(to_tsvector('english', NEW.title), 'A') || 
                setweight(to_tsvector('english', (SELECT name FROM colour WHERE colour.id = NEW.colourID)), 'B') ||
                setweight(to_tsvector('simple', (SELECT name FROM brand WHERE brand.id = NEW.brandID)), 'B') ||
                setweight(to_tsvector('simple', (SELECT username FROM "user" WHERE "user".id = NEW.sellerID)), 'B') ||
                setweight(to_tsvector('english', NEW.description), 'C');
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$ 
LANGUAGE 'plpgsql';



------------------------------TRIGGERS------------------------------


CREATE TRIGGER bid_rules
    BEFORE INSERT ON bid
    FOR EACH ROW
    EXECUTE PROCEDURE bid_rules();

CREATE TRIGGER update_auction
    AFTER INSERT ON bid
    FOR EACH ROW
    EXECUTE PROCEDURE update_auction();

CREATE TRIGGER help_message_types
    BEFORE INSERT ON helpMessage
    FOR EACH ROW
    EXECUTE PROCEDURE help_message_types();


CREATE TRIGGER rating_rules
    BEFORE INSERT ON rating
    FOR EACH ROW
    EXECUTE PROCEDURE rating_rules();


CREATE TRIGGER delete_rules
    BEFORE DELETE ON "user"
    FOR EACH ROW
    EXECUTE PROCEDURE delete_rules();


CREATE TRIGGER notify_rating
    AFTER INSERT ON rating
    FOR EACH ROW
    EXECUTE PROCEDURE notify_rating();


CREATE TRIGGER notify_help_message
    AFTER INSERT ON helpMessage
    FOR EACH ROW
    EXECUTE PROCEDURE notify_help_message();


CREATE TRIGGER notify_favorite_sellers
    AFTER INSERT ON auction
    FOR EACH ROW
    EXECUTE PROCEDURE notify_favorite_sellers();


CREATE TRIGGER fts_auction_insert
    BEFORE INSERT ON auction
    FOR EACH ROW
    EXECUTE PROCEDURE auction_search_update();


CREATE TRIGGER fts_auction_update
    BEFORE UPDATE ON auction
    FOR EACH ROW
    EXECUTE PROCEDURE auction_search_update();




------------------------------------------------------------------------------------------------




INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Ainsley Flowerden', 'aflowerden0', 'aflowerden0@posterous.com', '$2y$10$RN/sxfu4igOErWPa9bz8NeUouFLkaHVdSdR2oWqHPZBtJibAicWxa', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Nappy Berrisford', 'nberrisford1', 'nberrisford1@netscape.com', '$2y$10$5yqLTD9qMuf6qKa.6FI7J.8wJdJP0dpy4I8qYbCjDZ0qn7GGU5pIK', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Giraud McFadin', 'gmcfadin2', 'gmcfadin2@washington.edu', '$2y$10$C0uwOfed7lbUufopZTAJy.wNaIekbvCBVh9rFRVnXFceRRLTtmXUm', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Xerxes Faber', 'xfaber3', 'xfaber3@cocolog-nifty.com', '$2y$10$77hXb7dDh9XzrJS.YfY.wOl0cyTpz/ORXV6GF9OaLjBVzDMHGNkQe', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Nealy Clousley', 'nclousley4', 'nclousley4@merriam-webster.com', '$2y$10$coJnxFSPJfu95oFfaylKSOvM2p2LqnmfwKE/x.Ab/ize5ASOvRfqC', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Lise Castro', 'lcastro5', 'lcastro5@w3.org', '$2y$10$wZmouxqE628FAI.vl6PBhORXV5k/KGDCMnz1GVzj0y2/PPkar2R5.', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Arlene Carlos', 'acarlos6', 'acarlos6@prlog.org', '$2y$10$RmJwVb4NIui81/GcprBwOuXjo2wbcoJJZbzTuws77.IxFxxCQclCi', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Stanislaus Monget', 'smonget7', 'smonget7@cafepress.com', '$2y$10$2JKunO8UKVonyJX2cpksye486A1xakKt15fCAhEXdSG1AIfI3pJZm', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Jerrold Ausher', 'jausher8', 'jausher8@storify.com', '$2y$10$FGqWkiOCSOCbpgNtGImCkuXSN1FVLDKzFioZD.9ibUKP9idkwyFn.', false, true);
INSERT INTO "user" (name, username, email, password, banned, admin) VALUES ('Giavani Gallon', 'ggallon9', 'ggallon9@europa.eu', '$2y$10$BWCev2Czhnby6cGXskgUhuNIsNAigp0IqzHB0H4oVQRFtpfaaMK1e', false, true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Augustine Huffadine', 'ahuffadine0', 'ahuffadine0@ihg.com', '$2y$10$0TonKWm1l9JX9vFGDGWZIeB0EVkJvtiDkWQWpGDnZA8ncug4DSz22', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Merwin Taffrey', 'mtaffrey1', 'mtaffrey1@pbs.org', '$2y$10$dFBseiBQe0qlZqNeL3PREOzYo5vYWQ6wO0WiNP9Xk6JaJD2q6bs3O', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Tabitha Ryce', 'tryce2', 'tryce2@cargocollective.com', '$2y$10$vrTCfi1vy4wOEUisbDcaserpkN6U/xKx8CX5VtNAP68I6gCTC99jO', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Caitrin Starie', 'cstarie3', 'cstarie3@miibeian.gov.cn', '$2y$10$hJEJKM9ZQ8NAK6rGMosPHuIU2T42EGs9hqyX6Mrh3vWly66flYUZi', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Costanza Jekyll', 'cjekyll4', 'cjekyll4@smugmug.com', '$2y$10$QzraLeGnPBwfgJ/nJ8IJD.ScIeWD4SogaEKeevWNik3IuRZsoFe/m', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Robbert Dionsetti', 'rdionsetti5', 'rdionsetti5@ycombinator.com', '$2y$10$xU1B1cNhPJuU8gu91rsxjODGEcMEHZ5k6yIGtdNiHdH4VJbJ5PQ1u', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Dar Earie', 'dearie6', 'dearie6@php.net', '$2y$10$OINrul02ByLX1bjtLnHCZ.kaOCE2jo7AR9JPrIC7wcGgugsa0XIOa', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Renata Treversh', 'rtreversh7', 'rtreversh7@miibeian.gov.cn', '$2y$10$.Srgq3pCoGsKM62YVg8bGekZiCq48ayNr/TNquX8MbMiHXrrkUZSG', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Mikkel Sherrum', 'msherrum8', 'msherrum8@vistaprint.com', '$2y$10$jobKw5SPaFC9YCsIgKvKs.7eL2T0AVCXBJaCzOzRsSvsLFBHwKA4K', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Robers Charville', 'rcharville9', 'rcharville9@google.fr', '$2y$10$wUEoV.tO0qmrbsZcX1Xv/.HtmXKftbal9AAMyuJ7vQFOlBBALkZ26', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Twila Waliszewski', 'twaliszewskia', 'twaliszewskia@uol.com.br', '$2y$10$Z3JPYiJmA5Omp0D4FyMw5uwykDcV4WWhqcJFRT7S8F/lxz.fxxW1C', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Karena Bryenton', 'kbryentonb', 'kbryentonb@ucsd.edu', '$2y$10$FGC665kcVySlYUC4IpLIxuQ6CGuJL93JlemVikYg7FqxEc0AU4xJq', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Sheelagh Cripps', 'scrippsc', 'scrippsc@hubpages.com', '$2y$10$4JJByRJzaxqQZOJUH6k4uucruBDIz.CEYt289rJWIT7zT4VW7n3nu', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Floris Braune', 'fbrauned', 'fbrauned@cam.ac.uk', '$2y$10$JdVYf5..Evhvlu7OurmarObLjT3/CCXGA.yVsmfR4AEw.Jf7GFafu', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Teddi Pittem', 'tpitteme', 'tpitteme@shareasale.com', '$2y$10$JdyG/mERoveDKHvMhDHUPeobBLzlFRU7kH/oSPNqv3aptaX8NS/5u', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Micheline Chancelier', 'mchancelierf', 'mchancelierf@reuters.com', '$2y$10$dFH2LlrRfa4./6mK6BuULewI3nePoxZXB/PTEe9tfKsw3ebhHOkVi', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Ellery Sibery', 'esiberyg', 'esiberyg@netlog.com', '$2y$10$9AuhEAsfXNVXFX3ZyJ.Ax.qY1p2Z5IGB0RluYYWhufVrU/RnPIUce', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Tamma Courcey', 'tcourceyh', 'tcourceyh@uol.com.br', '$2y$10$7JQXvUwDOM1zdTwzxJ9eyuZW8IM15QB8nPSIRVryiFj42wXqv6SUC', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Electra Barbosa', 'ebarbosai', 'ebarbosai@ezinearticles.com', '$2y$10$oze9L0I0oeUIhy9ZZKf7/eXbVNLDFzBRO.O35nQBKTKD6aPcl0ADq', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Ferris Knee', 'fkneej', 'fkneej@diigo.com', '$2y$10$MkmsUxCkdXVc8DRFWaCOcuTEouQ4P6kp9vi2DWZVDoSN4C2uwAp9u', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Rad Keems', 'rkeemsk', 'rkeemsk@ihg.com', '$2y$10$PP1Aj1VNgV4vqwufkF2paeauHBhvclACYNCuaoW15Kz6h4IbYHP6e', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Ella Thoresby', 'ethoresbyl', 'ethoresbyl@acquirethisname.com', '$2y$10$ncKAS.daYmawozmfIHWe1ueMD6i.t1PCn561s3PvMwBy1r1o3QPQu', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Odo Sowray', 'osowraym', 'osowraym@go.com', '$2y$10$IRnoVutC9vvJPO44K9LxtuHfAVrZslWQ8nWFOaoXpUMiz9qo4mQTm', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Freemon Von Brook', 'fvonn', 'fvonn@clickbank.net', '$2y$10$nq8S6XmYB19tBOyR7NL55uuYQ1IForPWyZxj5.P6L99de3Y7vyZuG', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Dill Ashbee', 'dashbeeo', 'dashbeeo@free.fr', '$2y$10$WyHG7jXA3B80cinvadih4.4zyFbkHm4oBz1AQZylzuvS2nKsQnYR.', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Sherrie Foulger', 'sfoulgerp', 'sfoulgerp@amazon.co.uk', '$2y$10$GGERVLlhHMg6Ao8.7EH.7eDE6kU0Hil8vda.90UfNWFem1jNWnxWO', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Tracy Clear', 'tclearq', 'tclearq@livejournal.com', '$2y$10$Ez.UeeL5e2osb3f1Dbst2ubKm0W/o5qzmuh.K.GgmOx/twjZAKcBi', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Salomone Pollastrino', 'spollastrinor', 'spollastrinor@pen.io', '$2y$10$MaaNcdw3DBEV3pEOUx62luOWQEZwX.cR.FaTBO9sLUjuBnt0.ua1G', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Laney Kynaston', 'lkynastons', 'lkynastons@mtv.com', '$2y$10$aSZaDC2afT2v3nBV19qbveBAE.Dc1F6E7GmYz8e6fcaWi91E4Dvni', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Timotheus Tal', 'ttalt', 'ttalt@icq.com', '$2y$10$mOI.jZhodEucr5brHmN8FOTAc0PezU7QDRuMY1PqafrdTaTSiahxa', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Chic Heakey', 'cheakeyu', 'cheakeyu@drupal.org', '$2y$10$KfqYUn0d6REpzop2BK5jbuJkL0/s9QEnwk25TpLMhmarch9eA/Bvi', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Grantley McKeurtan', 'gmckeurtanv', 'gmckeurtanv@istockphoto.com', '$2y$10$czoShz0nMA7n3CgqnVozWOfSydXujIiz6CtkVtbNaEAaYUAxc09H2', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Kipp Arnot', 'karnotw', 'karnotw@nyu.edu', '$2y$10$YLevZnrx9Lsft5jbaRpbfeixK0HkyA6J0aNl9V.tgtMwJCxxovAFa', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Maximilian Duly', 'mdulyx', 'mdulyx@newsvine.com', '$2y$10$0gzQeeBKFrzLqbo2Yn4ndu3cc8Qmxy2L8ox1H.fnXCsoC2c7ucYuu', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Antoni Sollars', 'asollarsy', 'asollarsy@blogtalkradio.com', '$2y$10$AF9NC4w/yRgm4PT3/KUt0eBCsLtxFiQxhLHZFqRlEDgiL4rXQVM6y', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Maddalena MacElholm', 'mmacelholmz', 'mmacelholmz@creativecommons.org', '$2y$10$YwG7xf0eTrC.0VbYLQLue.rQwF99GyRu3tDmP/6cNX.OHmtLEh1nm', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Peyter Knowlden', 'pknowlden10', 'pknowlden10@nhs.uk', '$2y$10$4eCl9OS2sxwCXrEbO0JO5uJ4InYp3D1k0NsEzX8heMLieYoJY4l7u', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Aldin Gerrels', 'agerrels11', 'agerrels11@huffingtonpost.com', '$2y$10$yWnWGqjeVWwodz5QMJkmPevFfw6h1zLJjxNkT3LeZQO1TZE7IuWcm', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Janeta Mathivet', 'jmathivet12', 'jmathivet12@com.com', '$2y$10$XRuIqFelfdPyMVPtIxwlf.AlKSv7tIbWEtsS34I9CHL9WxG2ssTIe', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Baillie Inchbald', 'binchbald13', 'binchbald13@tmall.com', '$2y$10$.QJ248av8KtIUx1ZYUc8HuPL1aW0/RHWKVD8rptJBWxLr8UaOivUe', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Donaugh Shier', 'dshier14', 'dshier14@blinklist.com', '$2y$10$GG1h/5Nba9hvOmG3Jglm5el0HQH4zr6lBDB52WL.sed.bZwjc7O4W', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Trevor McGirl', 'tmcgirl15', 'tmcgirl15@booking.com', '$2y$10$obNferuFDSeU930PJZfR8eb4kPslsER5XxtaWsDlWLstKCBhLH9hW', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Boonie McPaike', 'bmcpaike16', 'bmcpaike16@mail.ru', '$2y$10$gvU8GfQk07zO/hRB0K9Ciu9BshXneUNCM58M6kJF1adcsc/4NM0va', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Marwin Bilovus', 'mbilovus17', 'mbilovus17@360.cn', '$2y$10$i8MWJMS4o88gAKjssckqfOxVJeO6a6QBK7gzabF44o8/sQkyXDXCu', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('West Hawke', 'whawke18', 'whawke18@angelfire.com', '$2y$10$RnpI82wiycBTrbpCKSjaTeQyQukd4X9Qh/G3S0lq2vUcSMyG6xjX2', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Cory Paschke', 'cpaschke19', 'cpaschke19@ocn.ne.jp', '$2y$10$qMncE9DzNe8mDEGKwzqA0O/gaIgHyr5KnXI5YCLsFzci41HrjI3yi', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Ted Nickell', 'tnickell1a', 'tnickell1a@google.it', '$2y$10$UmgjSsacCCkQBtb6gbCsle35J/jAbaVeQ97ha9IC6vasU8U7v1Vuy', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Martguerita Ealam', 'mealam1b', 'mealam1b@dion.ne.jp', '$2y$10$ji1jA.XNG20AUGFA4A.Ea.K6Lrbx8Ch3B0JK2INJz7aJo3JADmk/i', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Gwenni Pybworth', 'gpybworth1c', 'gpybworth1c@about.me', '$2y$10$PTGhr..aNVP0A//pd5IsCuQrkyVxMcccUK4aEbCjxwKXOxGjQ92la', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Bronson Dunbobin', 'bdunbobin1d', 'bdunbobin1d@who.int', '$2y$10$OX8m0cXa6X8CBRDAcEv.6.UBPP0eClyvdpjbvr9GXuB7h5zblzCHC', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Algernon Laffling', 'alaffling1e', 'alaffling1e@springer.com', '$2y$10$arhyGhIjkiJXoD1PuvH7o.iz3cNSrRqS3u9xP7vQS2N32lSrnL.vq', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Obed Matzl', 'omatzl1f', 'omatzl1f@squidoo.com', '$2y$10$AjnoPPx7c33snEt9PVHRr.4RhxfkayKqNC.U7vEgvVO6wCs/IX9G2', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Karylin Georgeou', 'kgeorgeou1g', 'kgeorgeou1g@cnet.com', '$2y$10$XLxjKkW.ZLGNoE7e5DJP9eZbcp9mcQn4MOkulPHmrVa8/xCHdoNZi', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Barron Ritchings', 'britchings1h', 'britchings1h@51.la', '$2y$10$SP6TyQB56HvfGXgDXSEVkOSB2vhUEd620rS5S0895CYA1fYWAAY0S', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Derek Sargeant', 'dsargeant1i', 'dsargeant1i@shop-pro.jp', '$2y$10$qD2uO1Ac0BTRoif61aiF7udjh9KqBifrefPgUNinzgnWUicEg/bkS', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Garik Maylour', 'gmaylour1j', 'gmaylour1j@odnoklassniki.ru', '$2y$10$8QIUVNkkL2Tev88tnqNcnO0yHijBlhve0oekiDXUD67RKqb9DbyGe', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Joni Pedrick', 'jpedrick1k', 'jpedrick1k@storify.com', '$2y$10$uOjjZ7YESQxnDjCdlwh0p.sjH8sustQkZJgypoAOBuPbS3w/U9Yg2', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Rosalyn Sheber', 'rsheber1l', 'rsheber1l@google.co.jp', '$2y$10$dRZRUdgM38hABc2rEzQch.nICo1czEjGTCYjBd18YuCORRB0qf1si', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Nehemiah Forrington', 'nforrington1m', 'nforrington1m@deviantart.com', '$2y$10$O1Ff.qGp9EC9KC2ObADOcedXzcQdIgmD4ovQwgHzxXjdEJMj4ykhG', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Halie Junes', 'hjunes1n', 'hjunes1n@utexas.edu', '$2y$10$WbrULf8E.7QibyI.7r9lAO0EJIeHqxFhgL1I8K7DEAV3n7iPzZHha', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Denney Snarie', 'dsnarie1o', 'dsnarie1o@google.cn', '$2y$10$WKZFupVozuCNfro2koXub.AE0m.qn39J.lhRPL/W.4yCm/Fev/UM6', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Eugenia Crosham', 'ecrosham1p', 'ecrosham1p@paginegialle.it', '$2y$10$xPVQNwbrptVSY3GvqsFpheHWWGEmEaLTkCgWojPhi6hhIDP.01qYW', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Mitchell Crutch', 'mcrutch1q', 'mcrutch1q@businessinsider.com', '$2y$10$za.jlOftiUZyFN7.R12Fp.0H7aXMqbTJ3d7d2/5penq/X7kffO.ge', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Marcelia Allaway', 'mallaway1r', 'mallaway1r@xinhuanet.com', '$2y$10$Ydf8kZwaap5e2ucm6eGbn.6hI/X2M7d4LJ/4C4nLMrcbWaYuaCVoa', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Tomasina Menat', 'tmenat1s', 'tmenat1s@uol.com.br', '$2y$10$WdGCmGZEknRLHvU6B8v9Ber2esCrodlx8Xa0eKMPUf6Hzw44KG0f2', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Clarissa Pyburn', 'cpyburn1t', 'cpyburn1t@phoca.cz', '$2y$10$IxyYmkjmdiXC/hgqUS9.guyyVB47cClq2jkAmOjBI5mvGXUupneAa', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Cyrille Mounsie', 'cmounsie1u', 'cmounsie1u@pinterest.com', '$2y$10$ExggaIrXOXiE91LpilAzm.McEvU.DY/f9qDm4Rbm02poz3orT7gn6', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Rebekkah Peris', 'rperis1v', 'rperis1v@independent.co.uk', '$2y$10$D7K/YHRS2aqduoHCwy1LPuzme4WXNCerIsISARDlWhStyXuRq6.um', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Lorinda Laker', 'llaker1w', 'llaker1w@dion.ne.jp', '$2y$10$B6F9BVhtuxV7ZDyo31pEXOZUh7jUQ5BKU76HpopXKDOAzu1ZjAIGe', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Ring Kemmey', 'rkemmey1x', 'rkemmey1x@homestead.com', '$2y$10$1XD9aKrLQGiCk7pzsfQ4W.kFOtxEdTzgmhJ26O6L16aUcEGwPq55y', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Charlie Koeppe', 'ckoeppe1y', 'ckoeppe1y@ca.gov', '$2y$10$M9h6jejBskLY4R.qe.7nSeqS6BXK/Dvr8WFq9uoDNJf8/Gmf6RCO.', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Valli Sidery', 'vsidery1z', 'vsidery1z@symantec.com', '$2y$10$nPZiygngx61CM1/CxUidZOsGCBUWQ.oHNoMjUb2UuAEKqDLQcSc4u', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Natalina Mathiasen', 'nmathiasen20', 'nmathiasen20@java.com', '$2y$10$Y//yERy4N6ZdMbBVHyRoF.z.Uc.RZhES4hf5bAs2deXFr1CLwzYni', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Kameko McTear', 'kmctear21', 'kmctear21@tumblr.com', '$2y$10$kWkZ7nKKoNzH3VKKqIH8fOGLNZhDqo1GN0FD..AECbna1OtntSTie', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Judd Kidsley', 'jkidsley22', 'jkidsley22@diigo.com', '$2y$10$sT0HQprkQj3w5QULno4g.uhyTDX2pAZmKHkKua4fZbFKf/phqkv56', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Angeline Gravie', 'agravie23', 'agravie23@gov.uk', '$2y$10$sm8hJRUjbmPvjw1zAaZdmudrxql.Yjr23g1YVAHWyxfjin0Q8hErq', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Eudora Grut', 'egrut24', 'egrut24@timesonline.co.uk', '$2y$10$ihSGf1qkET7QO47/fC5hzuJfPif5TO2R3ckk/4QD1639JQ1JddO1y', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Merci Bril', 'mbril25', 'mbril25@flickr.com', '$2y$10$0CFPccokLSDOaTr1kJTzIuYXyfuEc5fIo4NRzLBXcstw1vh4E0kSu', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Toby Joffe', 'tjoffe26', 'tjoffe26@google.it', '$2y$10$at2jf/SH0Y9yt3935lH5m.i4Yi66MIfbTUcf/Mz/ORP1HBqj.X9P2', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Clyve Sickert', 'csickert27', 'csickert27@prnewswire.com', '$2y$10$4lGJIUQJX1DfpHUzkMty8OfHil2UtSxi2VOmq4wFWF1qggxlO3EIy', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Rosene Neasam', 'rneasam28', 'rneasam28@virginia.edu', '$2y$10$Ut0T5aLvbkPpHmh0zfdAnuQFXFribQUZ2ipcJ8MRTAjBtHT2lx97i', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Nari Snaddon', 'nsnaddon29', 'nsnaddon29@ca.gov', '$2y$10$CwqwoClZa0wAh/LjIEat/.rM30u.298YetvMe2a8/wQiuyMtBNpli', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Dehlia Tremmel', 'dtremmel2a', 'dtremmel2a@google.de', '$2y$10$OhkyvId8zyefJq/JgjZkTeOxca4O51C1YDUINyjje/LocFMrYG3/2', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Gabie Gier', 'ggier2b', 'ggier2b@rediff.com', '$2y$10$bJdH96k/zyRs4dNKSg2pZuXRWmJMKL7g5jVhBSwadzkj/QFFvXmKW', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Briny Dales', 'bdales2c', 'bdales2c@cafepress.com', '$2y$10$KlD/cFpNsMZJlkLRPmvFOe26azWvUOXSReB8owS9Z/VYe3dbX/Kwe', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Dominique Wooller', 'dwooller2d', 'dwooller2d@icio.us', '$2y$10$E3iOOXdK8NCgInJWp6wml.e9uuMKP5sUt1.HHyGkSyqxPNAxo1jMS', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Meryl Dahle', 'mdahle2e', 'mdahle2e@pcworld.com', '$2y$10$.TO08cVG6yXCN6I3FjWdg.sGG0mutopOl1Yvybg.1nwpge.lxr6iy', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Fayre Maren', 'fmaren2f', 'fmaren2f@ebay.co.uk', '$2y$10$NkFVeDfrG204luBlv4en5ujm44nNyl57wrVSMbc36F7QzQf5pnkHq', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Martica Mougeot', 'mmougeot2g', 'mmougeot2g@msu.edu', '$2y$10$HMZPJ5a85po.PueBOLDTxOZ2xt02lNb/osGUFScGBfZROJf1fNpN.', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Packston Beck', 'pbeck2h', 'pbeck2h@dyndns.org', '$2y$10$vY3kWFqeJA.gb0imd/.yeesA2ZERP/FqrHOFz.wjlcK8SsXR8AQJi', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Stephen Kares', 'skares2i', 'skares2i@posterous.com', '$2y$10$CHty4aorVfT5dQtylFR5WO.A5H.paLvTRiTVAokXTJHarKn3aeYlu', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('North Vynehall', 'nvynehall2j', 'nvynehall2j@odnoklassniki.ru', '$2y$10$ePsfPN/i01/5ToH.lWPCxOoHjpzba5vg8ZbFcYoS4JiSQwz9Yh.v6', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Bail Greir', 'bgreir2k', 'bgreir2k@amazon.com', '$2y$10$osSCGnIXgynBOuq1pgy5Eua2HmmNMF4ZEl4/onbFbE9OSy009ZPp6', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Truman Humbee', 'thumbee2l', 'thumbee2l@reverbnation.com', '$2y$10$WjrrgCKTJUcG7DaUwhthdOYOOPgMsLh8TH8Nq8G3fq/4yi5bHzWxW', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Mirilla Naper', 'mnaper2m', 'mnaper2m@seattletimes.com', '$2y$10$4gPdbKPRVe9SGWPzGOjlkukhztwAc07XaSATMXHM5ZkFYNBmoF5Ma', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Jessey Benjamin', 'jbenjamin2n', 'jbenjamin2n@shop-pro.jp', '$2y$10$vG7EKDQMif6o5Ov8Kg.XwuoDpmxiO1mKbHQV9H0lIIIBwSfUHlabe', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Burtie Spours', 'bspours2o', 'bspours2o@house.gov', '$2y$10$m.XjeBiRwQiO1aSC5O0vqOu6Ws0Ab7mhf9z2xPsgVLK5XllgZFnO2', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Zed Wardhaw', 'zwardhaw2p', 'zwardhaw2p@posterous.com', '$2y$10$5Ffb6cycuDxjj4xobU6yNeibZj72inwNkfn6tx8gpChXgmg6HUmXu', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Cecily Fitzjohn', 'cfitzjohn2q', 'cfitzjohn2q@businesswire.com', '$2y$10$GGZJihnm69GZ.J6srFWyUO18nlAtpGsXBz6TXeiBB.wU5trEQFFQ6', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Roanne Aylmore', 'raylmore2r', 'raylmore2r@yellowpages.com', '$2y$10$CEJidURCGoEF.HIR8UqsfOv.8qcbmW5hxupwk/PeUr2BCrEmst/IW', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Zacharias Edleston', 'zedleston2s', 'zedleston2s@rediff.com', '$2y$10$nX/Q/UWpeAtW1sqOkO7wc.QgZWoplz7kaY0caeawLmCz4uEp7ZnpO', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Shanan Mauchline', 'smauchline2t', 'smauchline2t@shop-pro.jp', '$2y$10$4A84p/qgj6GHy4oLhEreOeDlZim9w8YWJKBeXmI5TCqucURCzGHDW', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Susan Oliveira', 'soliveira2u', 'soliveira2u@wp.com', '$2y$10$0rEbSxrFQRclVuznxw/nQuoVhhVuDiF4OBKNpnLdtvjx2k4iZYJoe', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Nikolos Jurgenson', 'njurgenson2v', 'njurgenson2v@timesonline.co.uk', '$2y$10$4qDuWI2xLhIA2vJ.GHhHnu6tSF4ybnKBTZ4iBzvdqxwxIoscJnjSG', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Alfonse Bauman', 'abauman2w', 'abauman2w@wikipedia.org', '$2y$10$v2ia340SdG7KbRr6rJIPc.49Z6RstBu/6iQcLXckqFmXCTrwIR8HO', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Clair Sidden', 'csidden2x', 'csidden2x@privacy.gov.au', '$2y$10$LvLe6mMPp/.5pmL0c1xRCeViuI4DXeDRQu9oPDhcHqB6nM58aPxIq', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Jarret Boich', 'jboich2y', 'jboich2y@umich.edu', '$2y$10$TFluWnii/N5IThc7eomMUOwe44QnZ8UeVLKaEPQA6ccuHiueWw4Si', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Chickie Gillingham', 'cgillingham2z', 'cgillingham2z@cbslocal.com', '$2y$10$K01Nq0S3onC.kVIxaj.BveIYDRJCakPXGB3d3/lAkD9M.JOqhAC/a', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Barthel Carbry', 'bcarbry30', 'bcarbry30@booking.com', '$2y$10$dSMxsjmz7AD9B.IkVmzDsOq0S3BwLfN.EvtU0UObPhHUJk6ZywIq.', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Avrom Brazelton', 'abrazelton31', 'abrazelton31@timesonline.co.uk', '$2y$10$ya37yhsPv7Bd.5hnl4uDrenUi9juJ2oaNJOu3iuz8jvaaIVVL2iR.', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Wildon Burford', 'wburford32', 'wburford32@biglobe.ne.jp', '$2y$10$.OHCyprdIc9ayjYYBjWyNu7MkAEKMddgN7/Ed4fQqu3h1erWlJJWq', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Meghan Bridges', 'mbridges33', 'mbridges33@hostgator.com', '$2y$10$8W3ai8er7VTNlRuA6CHC3.MTmuuJhF0sHTrgAC0WLf4xc4yKo8huO', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Shelagh Audley', 'saudley34', 'saudley34@creativecommons.org', '$2y$10$kh1M21dvpiaw7gzzAswu1.ia2.KHGSHiprpegsFd1uWIQzhKrG3l6', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Ivar Stefi', 'istefi35', 'istefi35@chronoengine.com', '$2y$10$jRebYYcgrolQwTA1m6Y5GOMvCMcgqgUVH/tEg3vru56k9.DieAQ5.', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Hunter Arlet', 'harlet36', 'harlet36@quantcast.com', '$2y$10$9TUQNvuU428nOzt1nyhJ2.zsn4OOBukm.etzcw3OM67mWq/K09pHG', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Brendon Herreros', 'bherreros37', 'bherreros37@about.com', '$2y$10$4VP/yfqQ5bC0auzqbFPA2uU35f36..Gxk/kbKuiWD4Mu5PuFxBc.S', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Cherye Westerman', 'cwesterman38', 'cwesterman38@ovh.net', '$2y$10$iZyNQ9yrAq1AJegCDabi6eDu1J3WZCYErRT6EdM1FFQzA/ldrVEsy', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Griselda Hackey', 'ghackey39', 'ghackey39@opensource.org', '$2y$10$Q4cM9ZbmFZ.RGlKZ64MgVuLc9wbvm0f8C65N4c97UPv1nIe3hPbpm', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Starla Dudeney', 'sdudeney3a', 'sdudeney3a@barnesandnoble.com', '$2y$10$G/X80mBYXne/kGmu1lBeEeu7IMPjDOJeYcpupwh2F1nLPedgAaaKy', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Ros Chivers', 'rchivers3b', 'rchivers3b@dot.gov', '$2y$10$zeeaAyQ9UZbS4IjOWOumbenlPL7AzgOEWvTBhiPJy9/pKVAijPTse', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Audie Hanrahan', 'ahanrahan3c', 'ahanrahan3c@hp.com', '$2y$10$T6cEIja/5pcFLsVX8v7UOO9Wkt3IKTVjxM/RMDeJxVkFuds1AllvK', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Lyndell Cumpsty', 'lcumpsty3d', 'lcumpsty3d@odnoklassniki.ru', '$2y$10$5BISOSwDLII8qv0iHVuIbuRcBrvsplfAP/tJZIZ869GzcFy9xsXPW', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Murray Hawsby', 'mhawsby3e', 'mhawsby3e@angelfire.com', '$2y$10$piCfYtOouwz2dWON0SgNpu4K7NRLnJ/IsLOOqTWi8qDlSIQ2ipZAa', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Hadleigh Soper', 'hsoper3f', 'hsoper3f@etsy.com', '$2y$10$nnCoOsWS.b.UXBk8vD789OlqNlX1X2q3ANZt3PSdVbqJGNPWvlTjq', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Christiana Jeandet', 'cjeandet3g', 'cjeandet3g@discuz.net', '$2y$10$4Yz.L7fqZhfOZ92pKTSjzeLhkW3PmTtRFVSbA.txHq8MG.pqWW7Qe', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Bonnie Penylton', 'bpenylton3h', 'bpenylton3h@noaa.gov', '$2y$10$GbX8VzFZGFPVasAqc4ssvOG9HrdbHX.Ue0/EMXqtVZcRf/ynygDPO', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Godfree Hammonds', 'ghammonds3i', 'ghammonds3i@google.nl', '$2y$10$zAsHU85LpL7m4VaPd.VOFOyXufH/e9BpBU5uC4iJ.bPAIUsRXuMXy', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Christi Ferries', 'cferries3j', 'cferries3j@goodreads.com', '$2y$10$8Ri8MiWAvpRu6CHA3iiSle2IfaBtG0tjWxghACiyuTiQByZxQbqB.', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Darrelle Fellibrand', 'dfellibrand3k', 'dfellibrand3k@reverbnation.com', '$2y$10$GaF3V2lsoB8bhzweRSOfpux6IjspYj0xLWJcEj08cpi53uvJDyZXi', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Cristiano Whithorn', 'cwhithorn3l', 'cwhithorn3l@omniture.com', '$2y$10$sxgcXUMJP5Xz274yOtWIBuI15ZkDt5C3givUPjljSAqiF97ilzLrq', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Cole Ream', 'cream3m', 'cream3m@1und1.de', '$2y$10$Lln67WV7yY4ybtvfcRxAjOcHp.DhbdMBz5wIrMcjxPqu.IZc90f7.', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Randell Edgson', 'redgson3n', 'redgson3n@japanpost.jp', '$2y$10$QEhRiJGdM9g0QQr1ZDvZDuOtSrGoA0s8c8neFKX5WDKCDwPvs9iOK', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Bondon Umpleby', 'bumpleby3o', 'bumpleby3o@pen.io', '$2y$10$frSs8dSlEcNE/q3Lll7TI..8W.RiA5kFuVfoL/6PhWQOCBXMGB6yq', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Derward Drinkwater', 'ddrinkwater3p', 'ddrinkwater3p@utexas.edu', '$2y$10$GFeHxPtH6jNvObU2g34I6eFRRs/MASqQPH6cbLDKELNPgUJDarUu2', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Worthington Beange', 'wbeange3q', 'wbeange3q@telegraph.co.uk', '$2y$10$2lYXidXeUnkBZcauwG3OgeFVu0BR1lWhc0ZdhbO6b91chReObf6g2', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Adham Blinkhorn', 'ablinkhorn3r', 'ablinkhorn3r@mayoclinic.com', '$2y$10$YixO4ugmPKsXDbRRS/wyEOJhPGuHMUPoXXhdKuIMDQXE2BO905ETy', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Andrea Helliker', 'ahelliker3s', 'ahelliker3s@alexa.com', '$2y$10$Q/wLBCNuq/m89HxrNDD1U.OxlamKq.ZYP/fxaPBkj2RT4zDLWg2Va', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Eben Duffitt', 'eduffitt3t', 'eduffitt3t@yahoo.com', '$2y$10$7SoziViwzKs.0ma.z5KTzeZd89f6FTeb.b.Vz.lLt/s05aWrq.c5C', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Karlis Blacket', 'kblacket3u', 'kblacket3u@cargocollective.com', '$2y$10$eYG8VRtuTcaSi5bWsIbdmuhVYylwHnv58fLHEqRXRJJ5o.xj0sfy6', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Enrichetta Laurenz', 'elaurenz3v', 'elaurenz3v@amazon.com', '$2y$10$HmlyWqqrw7L3bap46PJ6AO6hqpNY0bTp.llzYGR2xvGIvd0riOk7O', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Thorstein Goschalk', 'tgoschalk3w', 'tgoschalk3w@networkadvertising.org', '$2y$10$kjGDB8HQd.Nanu//ORE16edhuelE3aBAKfrFGgLImEn31pSnAstIK', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Eleen McQuaide', 'emcquaide3x', 'emcquaide3x@theglobeandmail.com', '$2y$10$EHbEl/FLHt9M9o7LO3d1yesESaQxxDqMVdVaFKg801Go2DmzQnmsS', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Leif Lawlee', 'llawlee3y', 'llawlee3y@ihg.com', '$2y$10$oP5Njbw5jjW7jtnHblFjiOGrEqxiG9.1CUJ4X5ZdxJKvYqp.9sm3C', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Farr Edgeson', 'fedgeson3z', 'fedgeson3z@theatlantic.com', '$2y$10$oT9HjJ52eiqjb7zT9IOCi.gyzdnhbmjucyLPeyrMA9PVbPIHYYM5u', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Fanechka Marians', 'fmarians40', 'fmarians40@sitemeter.com', '$2y$10$X4LWOpKAjmHl7KVGqaNgK.i94DJhpwZcdsmnO9cSdasklfMb1zgp2', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Allayne Bartholomew', 'abartholomew41', 'abartholomew41@earthlink.net', '$2y$10$8zxZWRT6uQBJz7128Eu8ieVWGexEnI31vVgckS57c2G03KZVsthdC', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Wynn MacElholm', 'wmacelholm42', 'wmacelholm42@hugedomains.com', '$2y$10$RhaESoXbygqD4CPpJBI6NepfB7SdXo9lkSMJlHfW./HUnqP4aLs5e', true);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Alyosha Vynarde', 'avynarde43', 'avynarde43@about.me', '$2y$10$v5WrA80l48Kx.ERA5i3boeFx/3yTaxUL5zzTUbEwisnvbDBHvO55m', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Zandra Gillbe', 'zgillbe44', 'zgillbe44@ask.com', '$2y$10$ivMnd7k4SCUfR/NweEgNye7ba52SqqlSrwo9uLAIgK5jRPgxENPAe', false);
INSERT INTO "user" (name, username, email, password, banned) VALUES ('Wright Cobbing', 'wcobbing45', 'wcobbing45@cafepress.com', '$2y$10$FD5bxVgUjTGChf4uJNal/OSNyOAmL3KbsfRsD95howdCQtoUG9Yuy', false);

INSERT INTO Colour (name) VALUES ('Mauv');
INSERT INTO Colour (name) VALUES ('Puce');
INSERT INTO Colour (name) VALUES ('Aquamarine');
INSERT INTO Colour (name) VALUES ('Red');
INSERT INTO Colour (name) VALUES ('Indigo');
INSERT INTO Colour (name) VALUES ('Pink');
INSERT INTO Colour (name) VALUES ('Khaki');
INSERT INTO Colour (name) VALUES ('Purple');
INSERT INTO Colour (name) VALUES ('Violet');
INSERT INTO Colour (name) VALUES ('Orange');
INSERT INTO Colour (name) VALUES ('Crimson');
INSERT INTO Colour (name) VALUES ('Blue');
INSERT INTO Colour (name) VALUES ('Dark Red');
INSERT INTO Colour (name) VALUES ('Green');
INSERT INTO Colour (name) VALUES ('Teal');
INSERT INTO Colour (name) VALUES ('White');
INSERT INTO Colour (name) VALUES ('Yellow');
INSERT INTO Colour (name) VALUES ('Black');
INSERT INTO Colour (name) VALUES ('Grey');


INSERT INTO Brand (name) VALUES ('Ferrari'); 
INSERT INTO Brand (name) VALUES ('Bugatti');
INSERT INTO Brand (name) VALUES ('Lamborghini');
INSERT INTO Brand (name) VALUES ('Bentley');
INSERT INTO Brand (name) VALUES ('Pagani');
INSERT INTO Brand (name) VALUES ('BMW');
INSERT INTO Brand (name) VALUES ('Mercedes');
INSERT INTO Brand (name) VALUES ('Audi');
INSERT INTO Brand (name) VALUES ('Citroen');
INSERT INTO Brand (name) VALUES ('Alfa Romeo');

INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (123,60);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (22,153);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (56,112);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (31,71);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (73,64);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (143,60);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (87,109);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (98,84);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (117,99);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (143,35);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (152,70);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (86,47);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (28,78);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (16,55);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (80,114);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (70,28);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (52,107);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (84,64);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (12,103);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (24,113);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (76,54);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (25,55);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (104,140);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (70,18);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (118,86);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (62,23);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (61,46);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (38,141);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (92,108);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (82,94);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (18,95);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (154,14);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (113,19);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (156,59);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (107,120);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (20,119);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (149,25);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (130,34);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (24,82);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (86,12);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (107,76);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (107,22);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (15,22);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (67,154);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (119,112);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (56,28);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (88,43);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (148,78);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (158,102);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (14,23);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (135,39);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (81,151);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (42,67);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (119,76);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (139,135);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (14,139);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (147,158);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (27,145);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (142,18);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (101,131);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (127,148);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (30,25);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (64,70);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (27,152);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (68,94);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (99,49);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (12,13);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (45,60);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (63,15);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (120,122);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (80,55);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (22,60);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (117,66);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (137,56);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (142,136);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (28,49);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (144,77);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (23,116);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (58,111);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (96,142);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (35,23);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (26,62);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (62,12);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (155,92);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (116,112);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (124,145);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (68,23);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (72,98);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (131,91);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (64,125);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (136,152);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (53,93);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (18,128);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (83,81);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (41,79);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (32,138);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (106,130);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (84,113);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (64,14);
INSERT INTO FavouriteSeller (user1ID,user2ID) VALUES (133,57);

INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Ferrari Portofino', 'The Ferrari Portofino (Type F164) is a grand touring sports car produced by the Italian automotive manufacturer Ferrari and has a 0–60 mph (0–97 km/h) time of 3.5 seconds.', 82, '2021-03-12 03:06:38', '2021-03-25 04:12:56', null, '1:64', 1, 17, 82);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Bugatti Chiron', 'Homage to the Monaco driver Louis Chiron who caught his first victory with a Bugatti, Chiron will be a dream for those who will drive it, but also for those, the majority, who will admire it, even if only on the desk.', 766, '2021-06-02 10:12:35', '2021-06-14 07:20:59', null, '1:43', 2, 18, 80);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Ferrari 812 Superfast', 'The most powerful and performing Ferrari ever made: this is the Ferrari 812 Superfast, the new masterpiece from the house of the Prancing Horse that was be unveiled at Geneva Motor Show 2017. A V12 engine with 800 HP will give to this supercar the incredible speed of 340 km/h.', 309, '2021-05-16 06:50:23', '2021-06-12 15:33:50', 2616, '1:18', 1, 4, 142);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Alfa Romeo 8C Competizione Spider', 'The Alfa Romeo 8C Competizione is a sports car produced by Italian automotive manufacturer Alfa Romeo between 2007 and 2010. It was first presented as a concept car at the 2003 Frankfurt Motor Show and later offered for sale for the 2007 model year. The name refers to the eight-cylinder (cilindro in Italian) engine (8C) and Alfa Romeo''s racing pedigree (Competizione, Italian for "competition"). The company received over 1,400 orders for the 8C after the official announcement that the car would enter production. However, only 500 customers ended up with the 8C Competizione and another 500 with the 8C Spider, bringing the production total to 1,000 cars.', 231, '2021-04-27 10:08:46', '2021-06-06 14:13:49', null, '1:64', 10, 16, 55);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Ferrari F12 Berlinetta', 'The Ferrari F12 Berlinetta is a grand tourer produced by Ferrari, an Italian sports car manufacturer. It was first introduced to the public at the Geneva Motor Show in 2012.', 777, '2021-06-01 10:57:24', '2021-06-10 15:06:44', null, '1:64', 1, 12, 89);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Ferrari 488 Spider', 'The Ferrari 488 (Type F142M) is a mid-engine sports car produced by the Italian automobile manufacturer Ferrari. The car replaced the 458, being the first mid-engine Ferrari to use a turbocharged V8 since the F40.', 688, '2021-05-11 11:10:10', '2021-06-18 21:02:29', null, '1:43', 1, 4, 146);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Lamborghini Quadra Roadster', 'The last dream by Automobili Lamborghini came true! Lamborghini Centenario Roadster was announced during the Monterey Car Week in California. A car that is a glance to the future and the state of art of Italian Design combined with high-performances.', 866, '2021-06-01 14:53:44', '2021-06-12 23:53:59', null, '1:64', 3, 18, 75);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Lamborghini Aventador S', 'An icon reinvented: this is the new Lamborghini Aventador S, the latest born from the house of the Raging Bull. A supercar with extreme performance and fantastic design.', 679, '2021-05-13 21:28:52', '2021-06-13 20:54:04', 2807, '1:8', 3, 12, 31);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Bentley New Continental GT', 'Create your dream Bentley in replica scale. Choose everything from the paint to the veneer in a totally bespoke commission. Bentley car models don’t come more customizable than this.', 735, '2021-05-07 14:03:41', '2021-06-12 19:24:41', null, '1:43', 4, 3, 46);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Lamborghini Huracán Performante', 'Huracan Performante is a car with incredible performance that set a new record in Nurburgring circuit with a time lap of 6:52.01 minutes, the best performances for a production car.', 824, '2021-03-04 00:26:32', '2021-03-08 05:55:36', 2107, '1:64', 3, 17, 43);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Ferrari Portofino', 'Shown for the first time at Frankfurt Motor Show 2017, the Ferrari Portofino is the new V8 dream from the house of the Prancing Horse.', 554, '2021-05-12 12:28:13', '2021-06-13 13:57:58', 2810, '1:18', 1, 3, 93);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Lamborghini Centenario Roadster', 'Now he last dream by Automobili Lamborghini came true! Lamborghini Centenario Roadster was announced during the Monterey Car Week in California. A car that is a glance to the future and the state of art of Italian Design combined with high-performances.', 181, '2021-05-30 06:59:54', '2021-06-08 21:58:18', null, '1:43', 3, 13, 74);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Pagani Huayra Roadster', 'Pagani Huayra Roadster is the new masterpiece of the house of San Cesario del Panaro and will be showed for the first time at Geneva Motorshow 2017 in March.', 746, '2021-04-29 16:07:57', '2021-05-31 19:16:36', null, '1:64', 5, 12, 98);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Alfa Romeo Racing C39', 'The Alfa Romeo Racing C39 is a Formula One car constructed by Alfa Romeo Racing to compete in the 2020 Formula One World Championship. The car was driven by Kimi Räikkönen and Antonio Giovinazzi, returning for their second year with the team.', 972, '2021-04-26 21:14:52', '2021-06-13 07:14:37', 4637, '1:18', 10, 4, 15);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Citroën 2CV', 'The Citroën 2CV ("two steam horses", "two tax horsepower") is an air-cooled front-engine, front-wheel-drive economy car introduced at the 1948 Paris Mondial de l''Automobile and manufactured by Citroën for model years 1948–1990.', 382, '2021-06-02 11:36:52', '2021-06-09 13:47:55', 1870, '1:8', 9, 7, 146);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('BMW i4', 'The BMW i4 is an all-electric five-door liftback styled sedan made by German automobile manufacturer BMW, marketed as a four-door coupé with sales commencing in 2021. The initial concept version, named BMW i Vision Dynamics, debuted at the 2017 Frankfurt Motor Show. It is the fifth BMW i sub-brand model, and will be sold in several variants at different performance levels.', 882, '2021-05-10 20:30:35', '2021-06-08 23:26:50', 2792, '1:64', 6, 16, 77);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Mercedes-Benz A-Class', 'The Mercedes-Benz A-Class is a subcompact executive car (regular subcompact in its first two generations) produced by the German automobile manufacturer Mercedes-Benz. The first generation (W168) was introduced in 1997, the second generation model (W169) appeared in late 2004 and the third generation model (W176) was launched in 2012. The fourth generation model (W177), which was launched in 2018, will mark the first time the A-Class is offered in the United States and Canada. This fourth generation A-Class will also be the first to be offered both as a hatchback (W177) and sedan (V177).', 519, '2021-05-14 15:36:09', '2021-06-08 19:00:35', null, '1:64', 7, 17, 147);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Audi TT RS', 'The Audi TT is a 2-door production sports car made by Audi since 1998, and currently in its third generation. The first two generations were assembled by the Audi subsidiary Audi Hungaria Motor Kft. in Győr, Hungary, using bodyshells manufactured and painted at Audi''s Ingolstadt plant and parts made entirely by the Hungarian factory for the third generation.', 370, '2021-05-16 04:46:16', '2021-05-24 07:50:01', null, '1:43', 8, 19, 69);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Ferrari 599XX Evo', 'At the 2009 Geneva Motor Show, Ferrari unveiled the track-only iteration of the 599 GTB, dubbed the 599XX. Designed by Ferrari''s Formula-one engineers, the car has many changes over the standard car in order to make it more nimble and responsive on a race track.', 979, '2021-05-13 12:22:45', '2021-06-11 10:16:26', 4786, '1:43', 1, 4, 20);
INSERT INTO Auction (title, description, startingPrice, startDate, finalDate, buyNow, scaleType, brandID, colourID, sellerID) VALUES ('Ferrari F12 Berlinetta', 'The Ferrari F12 berlinetta (Type F152) is a front mid-engine, rear-wheel-drive grand tourer produced by Italian automobile manufacturer Ferrari. The F12berlinetta debuted at the 2012 Geneva Motor Show, and replaces the 599 grand tourer. The naturally aspirated 6.3 litre Ferrari V12 engine used in the F12berlinetta has won the 2013 International Engine of the Year Award in the Best Performance category and Best Engine above 4.0 litres. The F12berlinetta was named "The Supercar of the Year 2012" by car magazine Top Gear. The F12berlinetta was replaced by the 812 Superfast in 2017.', 176, '2021-03-11 01:20:07', '2021-03-15 00:50:16', 1694, '1:18', 1, 14, 120);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_01.jpg',1);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_02.jpg',1);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_03.jpg',1);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_04.jpg',1);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_05.jpg',1);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_06.jpg',1);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_07.jpg',1);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/08/bugatti-chiron-black_01.jpg',2);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/08/bugatti-chiron-black_02.jpg',2);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/08/bugatti-chiron-black_03.jpg',2);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/08/bugatti-chiron-black_04.jpg',2);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/08/bugatti-chiron-black_05.jpg',2);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/08/bugatti-chiron-black_06.jpg',2);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/08/bugatti-chiron-black_07.jpg',2);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_01.jpg',3);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_02.jpg',3);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_03.jpg',3);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_04.jpg',3);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_05.jpg',3);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_06.jpg',3);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_07.jpg',3);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/08/0000056-alfa02a.jpg', 4);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/06/ferrari-f12tdf-blu_01.jpg',5);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/06/ferrari-f12tdf-blu_02.jpg',5);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/06/ferrari-f12tdf-blu_03.jpg',5);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/06/ferrari-f12tdf-blu_04.jpg',5);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/06/ferrari-f12tdf-blu_05.jpg',5);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2016/06/ferrari-f12tdf-blu_06.jpg',5);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/11/ferrari_488_spider_scale_1_18_fe017-1.jpg',6);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/11/ferrari_488_spider_scale_1_18_fe017-2.jpg',6);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/11/ferrari_488_spider_scale_1_18_fe017-3.jpg',6);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/11/ferrari_488_spider_scale_1_18_fe017-4.jpg',6);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/11/ferrari_488_spider_scale_1_18_fe017-5.jpg',6);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/11/ferrari_488_spider_scale_1_18_fe017-6.jpg',6);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/11/ferrari_488_spider_scale_1_18_fe017-7.jpg',6);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-centenario-roadster-black_01.jpg',7);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-centenario-roadster-black_02.jpg',7);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-centenario-roadster-black_03.jpg',7);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-centenario-roadster-black_04.jpg',7);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-centenario-roadster-black_05.jpg',7);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-centenario-roadster-black_06.jpg',7);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-centenario-roadster-black_07.jpg',7);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/lamborghini-aventador-s-blue_01.jpg',8);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/lamborghini-aventador-s-blue_02.jpg',8);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/lamborghini-aventador-s-blue_03.jpg',8);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/lamborghini-aventador-s-blue_04.jpg',8);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/lamborghini-aventador-s-blue_05.jpg',8);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/lamborghini-aventador-s-blue_06.jpg',8);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/lamborghini-aventador-s-blue_07.jpg',8);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/bentley-new-continental-gt-01.jpg',9);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/bentley-new-continental-gt-02.jpg',9);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/lamborghini-performante-yellow_01.jpg',10);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/lamborghini-performante-yellow_02.jpg',10);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/lamborghini-performante-yellow_03.jpg',10);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/lamborghini-performante-yellow_04.jpg',10);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/lamborghini-performante-yellow_05.jpg',10);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/lamborghini-performante-yellow_06.jpg',10);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/10/lamborghini-performante-yellow_07.jpg',10);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-azzurro_01.jpg',11);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-azzurro_02.jpg',11);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-azzurro_03.jpg',11);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-azzurro_04.jpg',11);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-azzurro_05.jpg',11);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-azzurro_06.jpg',11);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-azzurro_07.jpg',11);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/07/Lamborghini-Aventador-J_28.jpg',12);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/07/Lamborghini-Aventador-J_29.jpg',12);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/07/Lamborghini-Aventador-J_23.jpg',12);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/07/Lamborghini-Aventador-J_24.jpg',12);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/07/Lamborghini-Aventador-J_25.jpg',12);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/07/Lamborghini-Aventador-J_26.jpg',12);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/07/Lamborghini-Aventador-J_27.jpg',12);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/pagani-huayra-roadster_01.jpg',13);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/pagani-huayra-roadster_02.jpg',13);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/pagani-huayra-roadster_03.jpg',13);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/pagani-huayra-roadster_04.jpg',13);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/pagani-huayra-roadster_05.jpg',13);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/pagani-huayra-roadster_06.jpg',13);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2017/02/pagani-huayra-roadster_07.jpg',13);

INSERT INTO Image (url, auctionID) VALUES ('https://wallpaperaccess.com/full/2014186.jpg',14);
INSERT INTO Image (url, auctionID) VALUES ('https://wallpaperaccess.com/full/2014211.jpg',14);
INSERT INTO Image (url, auctionID) VALUES ('https://www.hdcarwallpapers.com/download/alfa_romeo_c38_formula_1_2019_4k_8k_3-3840x2160.jpg',14);
INSERT INTO Image (url, auctionID) VALUES ('https://wallpaperpure.net/wp-content/uploads/2018/07/98db488fabbe55f09867c48e0a81e621.jpeg',14);

INSERT INTO Image (url, auctionID) VALUES ('https://thumbs.dreamstime.com/b/um-carro-%C3%A9pico-de-citroen-cv-108609598.jpg',15);
INSERT INTO Image (url, auctionID) VALUES ('https://thumbs.dreamstime.com/b/profile-od-citroen-cv-two-horses-power-toy-car-isolated-against-white-background-epic-rear-citroen-cv-car-108613673.jpg',15);
INSERT INTO Image (url, auctionID) VALUES ('https://thumbs.dreamstime.com/b/da-epopeia-um-carro-de-citroen-cv-para-tr%C3%A1s-108802926.jpg',15);

INSERT INTO Image (url, auctionID) VALUES ('https://www.bmw.pt/content/dam/bmw/common/all-models/i-series/i4/landingpage/bmw-i4-mini-landingpage-ms-01.jpg/_jcr_content/renditions/cq5dam.resized.img.585.low.time1615557676860.jpg',16);
INSERT INTO Image (url, auctionID) VALUES ('https://www.bmw.pt/content/dam/bmw/common/all-models/i-series/i4/landingpage/bmw-i4-mini-landingpage-ms-02.jpg/_jcr_content/renditions/cq5dam.resized.img.585.low.time1615557677213.jpg',16);
INSERT INTO Image (url, auctionID) VALUES ('https://www.bmw.pt/content/dam/bmw/common/all-models/i-series/i4/landingpage/bmw-i4-mini-landingpage-ms-03.jpg/_jcr_content/renditions/cq5dam.resized.img.585.low.time1615557677658.jpg',16);
INSERT INTO Image (url, auctionID) VALUES ('https://www.bmw.pt/content/dam/bmw/common/all-models/i-series/i4/landingpage/bmw-i4-mini-landingpage-ms-04.jpg/_jcr_content/renditions/cq5dam.resized.img.585.low.time1615557677803.jpg',16);

INSERT INTO Image (url, auctionID) VALUES ('https://www.mercedes-benz.pt/passengercars/mercedes-benz-cars/models/a-class/hatchback-w177/amg/amg-equipment/_jcr_content/swipeableteaserbox/par/swipeableteaser/asset.MQ6.12.20190806161151.jpeg',17);
INSERT INTO Image (url, auctionID) VALUES ('https://www.mercedes-benz.pt/passengercars/mercedes-benz-cars/models/a-class/hatchback-w177/amg/amg-equipment/_jcr_content/swipeableteaserbox/par/swipeableteaser_1273306051/asset.MQ6.12.20190806161151.jpeg',17);
INSERT INTO Image (url, auctionID) VALUES ('https://www.mercedes-benz.pt/passengercars/mercedes-benz-cars/models/a-class/hatchback-w177/amg/amg-equipment/_jcr_content/swipeableteaserbox/par/swipeableteaser_1672679856/asset.MQ6.12.20190806161151.jpeg',17);

INSERT INTO Image (url, auctionID) VALUES ('https://www.audi.pt/content/dam/nemo/models/tt/tt-rs-roadster/my-2017/1920x1080-gallery/1920x1080_A162850_large.jpg?output-format=webp&downsize=1459px:*',18);
INSERT INTO Image (url, auctionID) VALUES ('https://www.audi.pt/content/dam/nemo/models/tt/tt-rs-roadster/my-2017/1920x1080-gallery/1920x1080_A162855_large.jpg?output-format=webp&downsize=1459px:*',18);
INSERT INTO Image (url, auctionID) VALUES ('https://www.audi.pt/content/dam/nemo/models/tt/tt-rs-roadster/my-2017/1920x1080-gallery/1920x1080_A162866_large.jpg?output-format=webp&downsize=1459px:*',18);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/08/Ferrari-599XX-Evo_017.jpg',19);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/08/Ferrari-599XX-Evo_027.jpg',19);

INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/08/Ferrari-F12-Berlinetta_0210.jpg',20);
INSERT INTO Image (url, auctionID) VALUES ('https://mrcollection.com/wp-content/uploads/2015/08/Ferrari-F12-Berlinetta_0110.jpg',20);

INSERT INTO FavouriteAuction (userID,auctionID) VALUES (151,15);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (135,2);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (124,6);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (90,8);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (88,11);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (138,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (100,12);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (123,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (99,10);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (17,8);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (160,7);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (115,4);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (134,11);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (82,14);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (98,14);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (126,18);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (130,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (142,20);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (57,18);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (24,3);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (148,8);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (94,17);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (20,1);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (12,14);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (11,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (145,14);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (52,4);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (61,6);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (12,19);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (149,12);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (135,20);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (72,4);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (81,18);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (81,12);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (37,4);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (94,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (105,13);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (49,15);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (114,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (151,4);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (56,12);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (140,9);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (53,11);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (15,15);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (141,13);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (47,20);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (49,8);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (158,18);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (48,6);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (108,4);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (60,14);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (127,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (134,10);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (63,17);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (69,6);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (79,4);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (147,20);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (160,13);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (122,11);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (47,13);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (146,15);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (70,17);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (53,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (136,17);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (135,16);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (131,15);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (149,17);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (137,19);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (144,11);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (132,13);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (17,16);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (141,12);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (76,12);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (55,15);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (83,13);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (125,1);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (41,16);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (51,6);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (71,12);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (149,6);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (96,14);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (46,18);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (61,9);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (40,18);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (110,20);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (94,18);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (38,17);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (30,15);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (106,10);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (152,15);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (92,16);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (150,20);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (98,17);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (27,14);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (98,7);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (39,12);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (39,10);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (95,10);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (143,5);
INSERT INTO FavouriteAuction (userID,auctionID) VALUES (47,5);

INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('ultrices posuere cubilia curae nulla dapibus dolor vel est donec odio justo', '2021-03-08 19:36:38', true, 155, 1);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('cras pellentesque volutpat dui maecenas tristique est et tempus semper est quam pharetra magna ac consequat', '2021-03-05 00:15:06', false, 35, 10);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('sapien iaculis congue vivamus metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc donec quis', '2021-03-07 07:47:16', true, 17, 4);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('vestibulum proin eu mi nulla ac enim in tempor turpis nec euismod scelerisque quam turpis adipiscing lorem vitae', '2021-03-04 18:41:48', true, 137, 2);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('mauris morbi non lectus aliquam sit amet diam in magna bibendum imperdiet nullam orci pede venenatis', '2021-03-07 17:53:37', true, 154, 6);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('porta volutpat erat quisque erat eros viverra eget congue eget', '2021-03-04 06:11:20', true, 121, 3);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('etiam justo etiam pretium iaculis justo in hac habitasse platea dictumst etiam faucibus cursus urna ut tellus', '2021-03-07 02:18:27', false, 48, 5);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('magnis dis parturient montes nascetur ridiculus mus vivamus vestibulum sagittis sapien cum sociis natoque penatibus et magnis dis', '2021-03-04 14:56:46', true, 154, 6);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit', '2021-03-05 19:14:44', false, 39, 1);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('mi nulla ac enim in tempor turpis nec euismod scelerisque quam turpis adipiscing lorem', '2021-03-06 14:52:43', false, 98, 9);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('ante vel ipsum praesent blandit lacinia erat vestibulum sed magna at nunc commodo placerat praesent blandit nam nulla integer', '2021-03-07 22:25:42', false, 38, 8);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('quam suspendisse potenti nullam porttitor lacus at turpis donec posuere metus vitae ipsum aliquam non mauris', '2021-03-05 01:04:22', false, 115, 4);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('enim leo rhoncus sed vestibulum sit amet cursus id turpis integer aliquet massa', '2021-03-08 21:05:36', false, 1, 155);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('maecenas tristique est et tempus semper est quam pharetra magna ac consequat metus sapien ut', '2021-03-07 10:15:20', true, 4, 17);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('ipsum primis in faucibus orci luctus et ultrices posuere cubilia', '2021-03-04 00:00:15', false, 2, 137);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('vel accumsan tellus nisi eu orci mauris lacinia sapien quis libero', '2021-03-07 19:45:20', false, 6, 154);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('integer aliquet massa id lobortis convallis tortor risus dapibus augue vel accumsan', '2021-03-04 09:23:51', true, 3, 121);
INSERT INTO HelpMessage (text, datehour, read, senderid, recipientid) VALUES ('viverra diam vitae quam suspendisse potenti nullam porttitor lacus at turpis donec posuere', '2021-03-04 16:05:27', false, 6, 154);

INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Such a cool car model, Lamborghini really surprises everyone!', '2021-03-04 18:45:39', 114, 8);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Awesome design, I hope I''ll have enough money to buy the real car when I grow up!', '2021-03-04 15:43:06', 35, 8);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('The wheels are the only good thing about this model...', '2021-03-05 06:03:28', 88, 20);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Whoa! What a cool model! Stole my mother''s credit card, I''m going for it', '2021-03-08 16:35:36', 71, 19);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Looks way too big and realistic for a model, kinda suspicious :/', '2021-03-04 00:47:39', 63, 17);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('The current value is actually pretty low, since this model costs way more in other markets.', '2021-03-08 09:21:12', 85, 5);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('The classic Citroen model! My great-great-great-grandfather had one of these, and it stayed in the family for several generations!', '2021-03-07 11:22:03', 54, 15);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('I saw that performance in the Nurburgring circuit live! Best day ever', '2021-03-07 06:30:16', 99, 10);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Hmmm not what I was looking for... I was searching for the Beta Juliet car, anyone knows an auction of that model?', '2021-03-06 23:01:09', 104, 4);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('I don''t really understand scales, I kinda skipped Math lessons. Isn''t 1:64 a little too big for my garage?', '2021-03-06 21:45:28', 78, 16);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Price is really high, who actually has that amount of money to spend in a car model?', '2021-03-06 22:03:37', 111, 12);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Leaving one portuguese expression for all those who think they have a chance against me in this one: Tu PõeteFino!', '2021-03-04 17:15:57', 30, 11);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Such big amounts of money in these small car models, world just doesn''t make sense anymore...', '2021-03-06 01:29:47', 105, 9);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('What a cool name, can''t say the same about the design tho', '2021-03-04 08:24:28', 124, 10);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('I don''t usually like Ferrari cars, but this one is actually pretty nice!', '2021-03-06 22:11:57', 57, 5);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Actually thinking about offering this model to my boyfriend in his birthday, you people recommend it?', '2021-03-07 18:21:58', 113, 1);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Nooo, it already ended? I really wanted this one :c', '2021-03-06 03:03:14', 123, 10);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('There''s an auction offering the same model, but in a differente colour, and that one has the Buy Now option, just warning you guys', '2021-03-07 21:39:55', 50, 1);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('My Competizione Spider series is almost complete! This is the only one missing, I''m coming for it!', '2021-03-04 17:53:22', 125, 4);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Is this the model that everybody talks about? I think they call it the ''Citroen do Paulo''', '2021-03-06 09:20:16', 152, 15);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('My favourite seller of all times! You go, man!', '2021-03-05 13:15:34', 68, 9);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Well, looks like my competition in this auction is pretty weak.', '2021-03-06 13:40:00', 124, 18);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('YES! I''M WINNING! I''M GETTING THIS MOD... Oh, nevermind, just refreshed the page.', '2021-03-05 14:16:16', 138, 1);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('OMG that colour is a joke, what an ugly model! Are people actually bidding on this?!', '2021-03-07 06:31:14', 23, 20);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Cool car! Would definitely want a model of it! I''m a beginner in car models collections, looking forward to win this as my first model!', '2021-03-08 13:14:36', 139, 16);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Yes, it is! The legendary car model :)', '2021-03-06 23:20:31', 70, 15);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Wowwwww a F1 car! This one promises to go high $$$$', '2021-03-05 03:22:36', 151, 14);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('These Ferrari''s series is so awesome :D', '2021-03-05 23:37:46', 72, 19);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('White? That car actually exists?? What about all the bird poop that falls on it? It wouldn''t be me cleaning it every single day...', '2021-03-05 15:38:29', 122, 4);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Looks like an Illuminati car, check that sixth photo! Suspicious, right?', '2021-03-05 11:36:04', 27, 2);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Such an amazing car model! I''m willing to give my kidney for it!!!', '2021-03-06 01:34:49', 19, 7);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Really looks like a racing car! Pretty nice design!', '2021-03-06 03:03:39', 137, 19);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Who''s the one always out-bidding me!? I''m starting to get angry! Stop man, please.', '2021-03-04 08:02:50', 87, 16);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('The blue and golden colours are the perfect match!', '2021-03-05 14:34:40', 37, 5);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Incredible. Lamborghini once again surprising everyone.', '2021-03-08 03:43:28', 139, 12);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('What a giant text in the description, I think I will wait for the movie to come out...', '2021-03-05 16:53:10', 21, 17);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Dammnnnn 340 km/h??? Thought that would only be possible in GTA!', '2021-03-04 06:18:14', 42, 3);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('The two horses are included on the purchase?', '2021-03-04 14:58:52', 42, 15);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Guys, is this site trust-worthy? Thinking about entering the car auctions community', '2021-03-05 13:34:59', 73, 19);
INSERT INTO Comment (text, datehour, authorid, auctionid) VALUES ('Very nice antique look, and the colour improves a lot the design!', '2021-03-08 18:44:58', 159, 9);

INSERT INTO Report (reason, dateHour, reporterID, stateType, locationAuctionID, reportedID) VALUES ('Inappropriate auction! Goes against website rules.', '2020-06-22 21:27:33', 96, 'Banned',1,82);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationAuctionID, reportedID) VALUES ('I dont like sim so he should be banned', '2020-01-13 01:57:43', 54, 'Discarded',18,69);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationCommentID, reportedID) VALUES ('He is blackmailing everyone. Who does he think he is? Pablo Escobar?', '2020-02-28 06:16:29', 66, 'Waiting',4,71);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationRegisteredID, reportedID) VALUES ('Inappropriate profile image! I really shoudnt be here doing you job! I aint paid for this, i just like cars', '2020-03-10 17:03:15', 27, 'Waiting',19, 19);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationAuctionID, reportedID) VALUES ('I dont like F1. This is supposed to be a car auction house, not a circus', '2020-06-13 14:08:03', 55, 'Waiting',14,15);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationCommentID, reportedID) VALUES ('Stop this guy. I bet tomorrow he will say the earth is dinosaur shaped lol', '2021-03-23 13:52:29', 52, 'Waiting',12,30);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationCommentID, reportedID) VALUES ('Pathetic comment haha. Ban!', '2020-07-27 18:15:16', 57, 'Waiting',7,54);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationRegisteredID, reportedID) VALUES ('Investigate this user, he is dangerous. I thi... I think he works for the FBI', '2020-08-03 11:57:05', 68, 'Waiting',45,45);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationRegisteredID, reportedID) VALUES ('He has the same profile image as i have. Unacceptable! Ban him!', '2021-03-09 04:49:21', 29, 'Waiting',23,23);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationCommentID, reportedID) VALUES ('Ban him! Look at the price! This is an attack to human integrity!', '2021-03-25 17:29:40', 93, 'Waiting',11,111);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationCommentID, reportedID) VALUES ('Look at the comment this user made! What was he thinking? Surely he will be banned ... right?', '2021-04-16 17:29:40', 111, 'Waiting',12,30);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationCommentID, reportedID) VALUES ('Inapropriate language, racist comments and offensive profile picture. Hamilton fan, sums it all...', '2021-04-16 17:29:40', 12, 'Waiting',27,151);
INSERT INTO Report (reason, dateHour, reporterID, stateType, locationAuctionID, reportedID) VALUES ('Why is this user still unbanned??', '2020-01-13 01:57:43', 54, 'Waiting',18,69);

INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (804, '2021-03-21 12:45:53', 129, 4);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1001, '2021-03-21 12:46:53', 115, 2);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1002, '2021-03-21 12:47:53', 76, 13);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1003, '2021-03-21 12:48:53', 58, 12);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1004, '2021-03-21 12:49:53', 70, 1);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1005, '2021-03-21 12:50:53', 119, 18);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1006, '2021-03-21 12:51:53', 75, 3);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1007, '2021-03-21 12:52:50', 99, 2);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1008, '2021-03-21 12:52:51', 107, 3);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1009, '2021-03-21 12:52:51', 39, 4);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1010, '2021-03-21 12:52:52', 77, 4);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1011, '2021-03-21 12:52:53', 16, 5);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1012, '2021-03-21 12:52:54', 59, 7);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1013, '2021-03-21 12:52:55', 14, 11);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1014, '2021-03-21 12:52:56', 39, 15);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1015, '2021-03-21 12:52:57', 122, 10);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1016, '2021-03-21 12:52:58', 114, 16);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1017, '2021-03-21 12:52:59', 129, 20);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1018, '2021-03-21 12:53:50', 102, 20);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1019, '2021-03-21 12:53:51', 147, 19);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1020, '2021-03-21 12:53:52', 30, 5);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1021, '2021-03-21 12:53:53', 52, 4);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1022, '2021-03-21 12:53:54', 127, 12);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1023, '2021-03-21 12:53:55', 108, 11);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1024, '2021-03-21 12:53:56', 24, 16);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1025, '2021-03-21 12:53:57', 65, 9);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1026, '2021-03-21 12:53:58', 58, 19);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1027, '2021-03-21 12:53:59', 59, 16);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1028, '2021-03-21 12:54:50', 89, 20);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1029, '2021-03-21 12:54:51', 144, 11);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1030, '2021-03-21 12:54:52', 102, 4);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1031, '2021-03-21 12:54:53', 66, 16);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1032, '2021-03-21 12:54:54', 87, 3);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1033, '2021-03-21 12:54:55', 146, 1);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1034, '2021-03-21 12:54:56', 82, 14);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1035, '2021-03-21 12:54:57', 23, 11);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1036, '2021-03-21 12:54:58', 149, 10);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1037, '2021-03-21 12:54:59', 58, 14);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1038, '2021-03-21 12:55:50', 84, 19);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1039, '2021-03-21 12:55:51', 114, 14);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1040, '2021-03-21 12:55:52', 82, 2);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1041, '2021-03-21 12:55:53', 97, 19);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1042, '2021-03-21 12:55:54', 63, 14);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1043, '2021-03-21 12:55:55', 118, 10);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1044, '2021-03-21 12:55:56', 139, 15);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1045, '2021-03-21 12:55:57', 111, 7);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1046, '2021-03-21 12:55:58', 117, 17);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1047, '2021-03-21 12:55:59', 53, 12);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1048, '2021-03-21 12:56:53', 120, 9);
INSERT INTO Bid (value, dateHour, authorID, auctionID) VALUES (1049, '2021-03-21 12:57:53', 67, 10);

INSERT INTO Rating (auctionID, winnerID, value, dateHour, comment) VALUES (1, 146, 1, '2021-03-15 22:12:09', 'metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc donec quis orci');
INSERT INTO Rating (auctionID, winnerID, value, dateHour, comment) VALUES (10, 67, 2, '2021-03-16 02:19:04', 'et ultrices posuere cubilia curae duis faucibus accumsan odio curabitur convallis duis consequat dui nec nisi');
INSERT INTO Rating (auctionID, winnerID, value, dateHour, comment) VALUES (15, 139, 2, '2021-03-09 00:48:27', 'dui luctus rutrum nulla tellus in sagittis dui vel nisl duis');
INSERT INTO Rating (auctionID, winnerID, value, dateHour, comment) VALUES (20, 89, 3, '2021-03-12 16:00:03', 'accumsan felis ut at dolor quis odio consequat varius integer ac leo');
