import { toRaw } from "vue";
import { getAccessToken } from "../getAccessToken.js";
import { getCart, getProductDataInCart } from "../Cart/getCart.js";
import Cart from "@/components/BuyingProcess/Cart.vue";

export async function checkout(paymentStatus: String, products: string[], shippingid: string, shippingstatus: string, totalprice: number, uuid: string) {
    const access_token = await getAccessToken();
    const url = 'https://techbox.developimpact.net/o/c/orderhistories/'
    const object = {
        "paymentStatus": paymentStatus,
        "products": products,
        "shippingid": shippingid,
        "shippingstatus": shippingstatus,
        "totalprice": totalprice,
        "uuid": uuid
    }
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + access_token
        }, body: JSON.stringify(object)
    })

    if (response.ok) {
        return true;
    }
}

export async function getCheckout(userid) {
    const access_token = await getAccessToken();

    const url = `https://techbox.developimpact.net/o/c/orderhistories/?filter=uuid%20eq%20%27${userid}%27`;
    const response = await fetch(url, {
        method: 'GET',
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + access_token,
        },
    });

    if (!response.ok) {
        throw new Error('Failed to fetch order histories');
    }

    const data = await response.json();

    const combinedData = await Promise.all(
        data.items.map(async (item) => {
            const productIds = JSON.parse(item.products).map((id) => Number(id));

            // Fetch cart data
            const Carts = await Promise.all(
                productIds.map(async (id) => {
                    const productUrl = `https://techbox.developimpact.net/o/c/carts/${id}`;
                    const productResponse = await fetch(productUrl, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${access_token}`,
                        },
                    });

                    if (!productResponse.ok) {
                        throw new Error(`Failed to fetch product with ID: ${id}`);
                    }

                    return productResponse.json();
                })
            );

            const productDetails = await Promise.all(
                Carts.map(async (cartItem) => {
                    const productUrl = `https://techbox.developimpact.net/o/c/products/${cartItem.productid}`;
                    const productResponse = await fetch(productUrl, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${access_token}`,
                        },
                    });

                    if (!productResponse.ok) {
                        throw new Error(`Failed to fetch product details for ID: ${cartItem.productid}`);
                    }
                    const data = await productResponse.json();

                    return {cartqty: cartItem.qty, productInfo:data}; 
                })
            );

            return {
                ...item,
                Carts,
                productDetails, // Resolved product details
            };
        })
    );

    // Accessing basePrice
    console.log(combinedData[0].productDetails[0]);
    
    console.log(combinedData);
    

    return combinedData;
}

