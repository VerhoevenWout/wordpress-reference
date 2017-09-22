-- CREATE VENUE TABLE
-- DONE
DROP TABLE IF EXISTS `venues`;
CREATE TABLE `venues` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` varchar(255) DEFAULT NULL,
  `Longitude` varchar(255) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venues`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('20308', '29911', '29912')
-- LIMIT 50

-- nl, en, fr

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE NL
-- DONE
DROP TABLE IF EXISTS `venuesNL`;
CREATE TABLE `venuesNL` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesNL`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('20308')
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE EN
-- DONE
DROP TABLE IF EXISTS `venuesEN`;
CREATE TABLE `venuesEN` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesEN`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('29911')
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE VENUE TABLE FR
-- DONE
DROP TABLE IF EXISTS `venuesFR`;
CREATE TABLE `venuesFR` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` longtext NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `InformationPicture` varchar(255) DEFAULT NULL,
  `Description` varchar(2000),
  `Keywords` varchar(255),
  `ContactInfo` varchar(500) DEFAULT NULL,
  `ExternalLink` varchar(255) DEFAULT NULL,
  `PageKeywords` varchar(255) DEFAULT NULL,
  `ContactEmail` varchar(255) DEFAULT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PersonsMin` int(11) DEFAULT NULL,
  `PersonsMax` int(11) DEFAULT NULL,
  `Halls` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zipcode` varchar(50) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Fax` varchar(50) DEFAULT NULL,
  `SocialMedia` varchar(1000) DEFAULT NULL,
  `Latitude` Decimal(9,6) DEFAULT NULL,
  `Longitude` Decimal(9,6) DEFAULT NULL,
  `ShortTitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venuesFR`
SELECT
ShopProducts.Id,
ShopProducts.PageId,
ShopProducts.CategoryId,
ShopProducts.Title,
ShopProducts.Content,
ShopProducts.Information,
'',
ShopProducts.Picture,
ShopProducts.InformationPicture,
ShopProducts.Description,
ShopProducts.Keywords,
ShopProducts.ContactInfo,
ShopProducts.ExternalLink,
ShopProducts.PageKeywords,
ShopProducts.ContactEmail,
ShopProducts.MainId,
ShopProducts.LinkedPages,
ShopProducts.City,
ShopProducts.PersonsMin,
ShopProducts.PersonsMax,
ShopProducts.Halls,
ShopProducts.Address,
ShopProducts.Zipcode,
ShopProducts.Phone,
ShopProducts.Fax,
ShopProducts.SocialMedia,
ShopProducts.Latitude,
ShopProducts.Longitude,
ShopProducts.ShortTitle
FROM ShopProducts
WHERE ShopProducts.PageId in ('29912')
-- LIMIT 50

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE CONCAT VENUETABLES TABLE
-- DONE
DROP TABLE IF EXISTS `venueTables`;
CREATE TABLE `venueTables` (
  `Id` int(11) NOT NULL,
  `Information` longtext NULL,
  `CapacityTable` longtext NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueTables`
SELECT
  venues.Id,
  venues.Information,
  venues.CapacityTable
FROM venues
-- LIMIT 500

UPDATE venueTables SET Information = replace(Information, '<h3>Capacity</h3>', '');

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE CONCAT VENUEIMAGES TABLE
-- DONE
-- FOR INSERT INTO VENUES
DROP TABLE IF EXISTS `venueImages`;
CREATE TABLE `venueImages` (
  `Id` int(11) NOT NULL,
  `ShopProductId` int(11) DEFAULT NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `PageId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueImages`
SELECT
  ShopProductImages.Id,
  ShopProductImages.ShopProductId,
  GROUP_CONCAT(ShopProductImages.Picture),
  ShopProducts.PageId
FROM ShopProductImages
-- WHERE ShopProductImages.ShopProductId in ('45482', '45484', '45485')

INNER JOIN ShopProducts ON ShopProductImages.ShopProductId = ShopProducts.Id
WHERE ShopProducts.PageId in ('20308', '29911', '29912')

GROUP BY ShopProductImages.ShopProductId
-- LIMIT 500
-- FOR DOWNLOAD
DROP TABLE IF EXISTS `venueImagesNoConcat`;
CREATE TABLE `venueImagesNoConcat` (
  `Id` int(11) NOT NULL,
  `ShopProductId` int(11) DEFAULT NULL,
  `Picture` varchar(255) DEFAULT NULL,
  `PageId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueImagesNoConcat`
SELECT
  ShopProductImages.Id,
  ShopProductImages.ShopProductId,
  ShopProductImages.Picture,
  ShopProducts.PageId
FROM ShopProductImages
-- WHERE ShopProductImages.ShopProductId in ('45482', '45484', '45485')

INNER JOIN ShopProducts ON ShopProductImages.ShopProductId = ShopProducts.Id
WHERE ShopProducts.PageId in ('20308', '29911', '29912');

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LIGGING PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLiggingParamsNL`;
CREATE TABLE `venueLiggingParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('9')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueLiggingParamsEN`;
CREATE TABLE `venueLiggingParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('16')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueLiggingParamsFR`;
CREATE TABLE `venueLiggingParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('18')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- NL/EN/FR

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT NL PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsNL`;
CREATE TABLE `venueFaciliteitParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('11')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;
-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT EN PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsEN`;
CREATE TABLE `venueFaciliteitParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('17')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;
-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT FR PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParamsFR`;
CREATE TABLE `venueFaciliteitParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('19')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;


-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueActiviteitParamsNL`;
CREATE TABLE `venueActiviteitParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
-- WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('10', '13', '12')
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2000')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueActiviteitParamsEN`;
CREATE TABLE `venueActiviteitParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2001')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

DROP TABLE IF EXISTS `venueActiviteitParamsFR`;
CREATE TABLE `venueActiviteitParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueActiviteitParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('2002')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsNL`;
CREATE TABLE `venueLocatieParamsNL` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsNL`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('10')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsEN`;
CREATE TABLE `venueLocatieParamsEN` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsEN`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('13')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;

-- VENUE LOCATIE PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLocatieParamsFR`;
CREATE TABLE `venueLocatieParamsFR` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParamsFR`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('12')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId;









-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- WOKING ON
DROP TABLE IF EXISTS `venueLinkedPages`;
CREATE TABLE `venueLinkedPages` (
  `Id` int(11) NOT NULL,
  `PageId` int(11) NOT NULL,
  `MainId` int(11) DEFAULT NULL,
  `LinkedPages` varchar(4000) DEFAULT NULL,
  `LinkedPagesValue` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueLinkedPages`
SELECT
  venues.Id,
  venues.PageId,
  venues.MainId,
  venues.LinkedPages,
  GROUP_CONCAT(Pages.Name)
FROM venues
INNER JOIN Pages ON venues.LinkedPages = Pages.Id
GROUP BY venues.Id

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE PLAATS PARAMS TABLE (NOT NECESSARY)
-- DROP TABLE IF EXISTS `venuePlaatsParams`;
-- CREATE TABLE `venuePlaatsParams` (
--   `ProductId` int(11) DEFAULT NULL,
--   `ComAdvancedSearchId` int(11) DEFAULT NULL,
--   `ConcatFilters` varchar(2000),
--   `ConcatFilterValues` varchar(2000)
-- );

-- INSERT INTO `venuePlaatsParams`
-- SELECT
--   ShopProductsComAdvancedSearchCategoryFilters.ProductId,
--   ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
--   GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
--   GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
-- FROM ShopProductsComAdvancedSearchCategoryFilters
-- INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
-- WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('8', '15', '20')
-- GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CONCAT VENUESEARCH PARAMS TABLE (NOT NECESSARY)
-- DROP TABLE IF EXISTS `venueSearchParams`;
-- CREATE TABLE `venueSearchParams` (
--   `ProductId` int(11) DEFAULT NULL,
--   `ComAdvancedSearchId` int(11) DEFAULT NULL,
--   `ConcatFilters` varchar(2000),
--   `ConcatFilterValues` varchar(2000)
-- );

-- INSERT INTO `venueSearchParams`
-- SELECT
--   ShopProductsComAdvancedSearchCategoryFilters.ProductId,
--   ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
--   GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
--   GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
-- FROM ShopProductsComAdvancedSearchCategoryFilters
-- INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
-- GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- FILTER VENUETABLES TABLE (NOT NECESSARY)
-- DROP TABLE IF EXISTS `venueTables`;
-- CREATE TABLE `venueTables` (
--   `Id` int(11) NOT NULL,
--   `ShopProductId` int(11) NOT NULL,
--   `Row` int(11) NOT NULL,
--   `Column` int(11) NOT NULL,
--   `Label` varchar(255) DEFAULT NULL,
--   PRIMARY KEY (`Id`)
-- );

-- INSERT INTO `venueTables`
-- SELECT
--   ShopProductValues.Id,
--   ShopProductValues.ShopProductId,
--   ShopProductValues.Row,
--   ShopProductValues.Column,
--   ShopProductValues.Label
-- FROM ShopProductValues
-- -- LIMIT 50
