<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property int $subcategory_id
 * @property int $unit_id
 * @property int $user_id
 * @property int|null $addressbook_id
 * @property float $store_price
 * @property float $admin_price
 * @property float $commision
 * @property bool $is_available
 * @property string $available_time
 * @property int $discount_id
 * @property float $final_price
 * @property bool $is_deleted
 * @property string|null $created_by
 * @property string|null $modified_by
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 * @property float|null $ratings
 *
 * @property \App\Model\Entity\Subcategory $subcategory
 * @property \App\Model\Entity\Unit $unit
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Addressbook $addressbook
 * @property \App\Model\Entity\Discount $discount
 * @property \App\Model\Entity\OrderItem[] $order_items
 */
class Product extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'image' => true,
        'description' => true,
        'subcategory_id' => true,
        'unit_id' => true,
        'user_id' => true,
        'addressbook_id' => true,
        'store_price' => true,
        'admin_price' => true,
        'commision' => true,
        'is_available' => true,
        'available_time' => true,
        'discount_id' => true,
        'final_price' => true,
        'is_deleted' => true,
        'created_by' => true,
        'modified_by' => true,
        'created_at' => true,
        'modified_at' => true,
        'ratings' => true,
        'subcategory' => true,
        'unit' => true,
        'user' => true,
        'addressbook' => true,
        'discount' => true,
        'order_items' => true
    ];
}
