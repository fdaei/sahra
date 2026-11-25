<?php

declare(strict_types=1);

namespace App\Enums;

enum PageSchemaType: string
{
    case WebPage = 'WebPage';
    case ItemPage = 'ItemPage';
    case AboutPage = 'AboutPage';
    case FAQPage = 'FAQPage';
    case QAPage = 'QAPage';
    case ProfilePage = 'ProfilePage';
    case ContactPage = 'ContactPage';
    case MedicalWebPage = 'MedicalWebPage';
    case CollectionPage = 'CollectionPage';
    case CheckoutPage = 'CheckoutPage';
    case RealEstateListing = 'RealEstateListing';
    case SearchResultsPage = 'SearchResultsPage';

    /** @return array<string, string> */
    public static function options(): array
    {
        return [
            self::WebPage->value => __('Web page'),
            self::ItemPage->value => __('Item page'),
            self::AboutPage->value => __('About page'),
            self::FAQPage->value => __('FAQ page'),
            self::QAPage->value => __('Question and answers page'),
            self::ProfilePage->value => __('Profile page'),
            self::ContactPage->value => __('Contact page'),
            self::MedicalWebPage->value => __('Medical web page'),
            self::CollectionPage->value => __('Collection page'),
            self::CheckoutPage->value => __('Checkout page'),
            self::RealEstateListing->value => __('Real estate listing'),
            self::SearchResultsPage->value => __('Search results page'),
        ];
    }
}
