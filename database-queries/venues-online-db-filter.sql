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

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- CREATE CONCAT VENUEIMAGES TABLE
-- DONE
DROP TABLE IF EXISTS `venueImages`;
CREATE TABLE `venueImages` (
  `Id` int(11) NOT NULL,
  `ShopProductId` int(11) DEFAULT NULL,
  `Picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
);

INSERT INTO `venueImages`
SELECT
  ShopProductImages.Id,
  ShopProductImages.ShopProductId,
  GROUP_CONCAT(ShopProductImages.Picture)
FROM ShopProductImages
-- WHERE ShopProductImages.ShopProductId in ('45482', '45484', '45485')
GROUP BY ShopProductImages.ShopProductId
-- LIMIT 500

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LIGGING PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueLiggingParams`;
CREATE TABLE `venueLiggingParams` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLiggingParams`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('9', '16', '18')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE LOCATIE PARAMS TABLE
-- TODO MERGE
DROP TABLE IF EXISTS `venueLocatieParams`;
CREATE TABLE `venueLocatieParams` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueLocatieParams`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('10', '15', '12')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE FACILITEIT PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venueFaciliteitParams`;
CREATE TABLE `venueFaciliteitParams` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venueFaciliteitParams`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('11', '19', '17')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId

-- --------------------------------------------------------------------
-- --------------------------------------------------------------------
-- VENUE PLAATS PARAMS TABLE
-- DONE
DROP TABLE IF EXISTS `venuePlaatsParams`;
CREATE TABLE `venuePlaatsParams` (
  `ProductId` int(11) DEFAULT NULL,
  `ComAdvancedSearchId` int(11) DEFAULT NULL,
  `ConcatFilters` varchar(2000),
  `ConcatFilterValues` varchar(2000)
);

INSERT INTO `venuePlaatsParams`
SELECT
  ShopProductsComAdvancedSearchCategoryFilters.ProductId,
  ComAdvancedSearchCategoryFilters.ComAdvancedSearchId,
  GROUP_CONCAT(ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId),
  GROUP_CONCAT(ComAdvancedSearchCategoryFilters.Name)
FROM ShopProductsComAdvancedSearchCategoryFilters
INNER JOIN ComAdvancedSearchCategoryFilters ON ShopProductsComAdvancedSearchCategoryFilters.ComAdvancedSearchCategoryFiltersId = ComAdvancedSearchCategoryFilters.Id
WHERE ComAdvancedSearchCategoryFilters.ComAdvancedSearchId in ('8', '15', '20')
GROUP BY ShopProductsComAdvancedSearchCategoryFilters.ProductId

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
