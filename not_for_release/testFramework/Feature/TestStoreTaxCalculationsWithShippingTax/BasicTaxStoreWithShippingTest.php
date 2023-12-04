<?php

namespace Feature\TestBasicTaxCalculationsNoShippingTax;

use Tests\Support\zcFeatureTestCaseStore;

class BasicTaxStoreWithShippingTest extends zcFeatureTestCaseStore
{
    private static $ready = false;
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        if (static::$ready) {
            return;
        }
        static::$ready = true;
        $this->createCustomerAccount('florida-basic1');
        $this->createCustomerAccount('US-not-florida-basic');
        $this->setConfiguration('STORE_PRODUCT_TAX_BASIS', 'Store');
    }

    public function testBasicCheckoutFloridaCustomer()
    {
        $this->loginCustomer('florida-basic1');
        $this->browser->request('GET', HTTP_SERVER . '/index.php?main_page=product_info&products_id=25');
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Microsoft', (string)$response->getContent() );
        $this->browser->submitForm('Add to Cart', [
            'cart_quantity' => '1',
            'products_id' => '25',
            ]);
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Your Shopping Cart Contents', (string)$response->getContent() );
        $this->browser->request('GET', HTTP_SERVER . '/index.php?main_page=checkout_shipping');
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Delivery Information', (string)$response->getContent() );
        $this->browser->submitForm('Continue', [
        ]);
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Payment Information', (string)$response->getContent() );
        $this->browser->submitForm('Continue', [
        ]);
        $this->assertStringContainsString('69.99', (string)$response->getContent() );
        $this->assertStringContainsString('2.50', (string)$response->getContent() );
//        $this->assertStringContainsString('4.90', (string)$response->getContent() );
        $this->assertStringContainsString('72.49', (string)$response->getContent() );
//        $this->assertStringContainsString('77.39', (string)$response->getContent() );
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Order Confirmation', (string)$response->getContent() );
        $this->assertStringContainsString('69.99', (string)$response->getContent() );
        $this->assertStringContainsString('2.50', (string)$response->getContent() );
//        $this->assertStringContainsString('4.90', (string)$response->getContent() );
        $this->assertStringContainsString('72.49', (string)$response->getContent() );
//        $this->assertStringContainsString('77.39', (string)$response->getContent() );
        $this->browser->submitForm('btn_submit_x', [
        ]);
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Your Order Number is:', (string)$response->getContent() );
    }

    public function testBasicCheckoutNonFloridaCustomer()
    {
        $this->loginCustomer('florida-basic1');
        $this->browser->request('GET', HTTP_SERVER . '/index.php?main_page=product_info&products_id=25');
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Microsoft', (string)$response->getContent() );
        $this->browser->submitForm('Add to Cart', [
            'cart_quantity' => '1',
            'products_id' => '25',
        ]);
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Your Shopping Cart Contents', (string)$response->getContent() );
        $this->browser->request('GET', HTTP_SERVER . '/index.php?main_page=checkout_shipping');
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Delivery Information', (string)$response->getContent() );
        $this->browser->submitForm('Continue', [
        ]);
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Payment Information', (string)$response->getContent() );
        $this->browser->submitForm('Continue', [
        ]);
        $this->assertStringContainsString('69.99', (string)$response->getContent() );
        $this->assertStringContainsString('2.50', (string)$response->getContent() );
//        $this->assertStringContainsString('4.90', (string)$response->getContent() );
        $this->assertStringContainsString('72.49', (string)$response->getContent() );
//        $this->assertStringContainsString('77.39', (string)$response->getContent() );
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Order Confirmation', (string)$response->getContent() );
        $this->assertStringContainsString('69.99', (string)$response->getContent() );
        $this->assertStringContainsString('2.50', (string)$response->getContent() );
//        $this->assertStringContainsString('4.90', (string)$response->getContent() );
        $this->assertStringContainsString('72.49', (string)$response->getContent() );
//        $this->assertStringContainsString('77.39', (string)$response->getContent() );
        $this->browser->submitForm('btn_submit_x', [
        ]);
        $response = $this->browser->getResponse();
        $this->assertStringContainsString('Your Order Number is:', (string)$response->getContent() );
    }
}
