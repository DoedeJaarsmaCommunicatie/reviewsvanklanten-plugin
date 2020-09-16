<?php

/**
 * Display a single product reviews from reviewsvanklanten.nl
 *
 * this template can be overridden
 * by copying it to yourtheme/woocommerce/single-product-reviews.php
 * like a normal WooCommerce partial-template.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined('ABSPATH') || exit;

if (!comments_open()) {
    return;
}

$product = wc_get_product();
$property = \Reviewsvanklanten\get_current_property();

$commenter = wp_get_current_commenter();
$user = wp_get_current_user();

$count = $property->reviewCount;

$woocommerce_rating_verification_not_required = get_option('woocommerce_review_rating_verification_required' ) === 'no';
$customerBoughtProduct                        = wc_customer_bought_product( '', get_current_user_id(), $product->get_id() );

do_action('rvk/reviews/before', $product, $property);
?>
<div id="reviews" class="woocommerce-Reviews">
    <div id="comments">
        <h2 class="woocommerce-Reviews-title">
            <?php
            if ($count) {
                /* translators: 1: reviews count 2: product name */
                $reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
                echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
            } else {
                esc_html_e( 'Reviews', 'woocommerce' );
            }
            ?>
        </h2>

        <?php
        if ($count > 0) {
            do_action('rvk/view/reviews/review/pre', $product, $property);
            print apply_filters('rvk/view/reviews/review', \Reviewsvanklanten\Helpers\View::make('reviews/single', [
                'review' => apply_filters('rvk/view/reviews/review/data', $property->latest_review(), $product, $property),
                'product' => $product,
                'property' => $property,
            ]));
            do_action('rvk/view/reviews/review/pre', $product, $property);
        } else {
            ?>
            <p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
            <?php
        }
        ?>
    </div>
    <?php if ($woocommerce_rating_verification_not_required || $customerBoughtProduct ) : ?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$form = \Reviewsvanklanten\Helpers\View::make('reviews/form', [
                    'reply_title' => $count > 0 ?
                            esc_html__( 'Add a review', 'woocommerce' ) :
                            sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
                    'redirect_url' => $product->get_permalink(),
                    'property_uuid' => $property->uuid,
                    'submit' => [
                        'link' => $property->get_link('reviews.create'),
                        'label' => esc_html__('Submit', 'woocommerce')
                    ],
                    'user' => [
                        'name' => $commenter['comment_author'] !== ''? $commenter['comment_author'] : $user->display_name,
                        'email' => $commenter['comment_author_email'] !== '' ? $commenter['comment_author_email'] : $user->user_email,
                    ],
                    'assets' => [
                        'script' => plugin_dir_url(RVK_FILE) . '/dist/main.js',
                        'style' => plugin_dir_url(RVK_FILE) . '/dist/main.css'
                    ],
                ]);

                do_action('rvk/views/reviews/form/pre', $product, $property, $form);

                print apply_filters('rvk/views/reviews/form', $form);

				do_action('rvk/views/reviews/form/post', $product, $property, $form);
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
	<?php endif; ?>
</div>
<?php
do_action('rvk/reviews/after', $product, $property);
