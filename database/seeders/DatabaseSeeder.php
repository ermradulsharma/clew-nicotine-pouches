<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AboutsSeeder::class,
            AdminsSeeder::class,
            AwardsSeeder::class,
            BannersSeeder::class,
            CartTempsSeeder::class,
            CartsSeeder::class,
            CategoriesSeeder::class,
            CheckoutsSeeder::class,
            ContactsSeeder::class,
            CountriesSeeder::class,
            CouponTempsSeeder::class,
            CouponsSeeder::class,
            CustomerPaymentProfilesSeeder::class,
            DiscountSeeder::class,
            DiscountsSeeder::class,
            FailedJobsSeeder::class,
            FaqsSeeder::class,
            FlavoursSeeder::class,
            LabelsSeeder::class,
            MappingsSeeder::class,
            MigrationsSeeder::class,
            NewsletterSubscriptionsSeeder::class,
            OrdersSeeder::class,
            PageBannersSeeder::class,
            PagesSeeder::class,
            PasswordResetTokensSeeder::class,
            PasswordResetsSeeder::class,
            PaymentLogsSeeder::class,
            PaymentsSeeder::class,
            PersonalAccessTokensSeeder::class,
            PressReleasesSeeder::class,
            ProcessesSeeder::class,
            ProductImagesSeeder::class,
            ProductReviewsSeeder::class,
            ProductSimilarsSeeder::class,
            ProductVariantsSeeder::class,
            ProductsSeeder::class,
            PromisesSeeder::class,
            RolesSeeder::class,
            SettingsSeeder::class,
            StatesSeeder::class,
            StoresSeeder::class,
            StrengthsSeeder::class,
            TickersSeeder::class,
            UserAddressesSeeder::class,
            UsersSeeder::class,
            WebsitesSeeder::class,
            WishlistsSeeder::class,
            WpCommentmetaSeeder::class,
            WpCommentsSeeder::class,
            WpLinksSeeder::class,
            WpOptionsSeeder::class,
            WpPostmetaSeeder::class,
            WpPostsSeeder::class,
            WpTermRelationshipsSeeder::class,
            WpTermTaxonomySeeder::class,
            WpTermmetaSeeder::class,
            WpTermsSeeder::class,
            WpUsermetaSeeder::class,
            WpUsersSeeder::class,
        ]);
    }
}
