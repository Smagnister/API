<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Discount Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property int $quantity
 * @property string|null $description
 * @property float $value
 * @property string $unit
 * @property \Cake\I18n\FrozenTime $expired_on
 * @property string $created_by
 * @property int $modified_by
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \App\Model\Entity\Product[] $products
 * @property \App\Model\Entity\Transport[] $transports
 */
class Discount extends Entity
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
        'quantity' => true,
        'description' => true,
        'value' => true,
        'unit' => true,
        'expired_on' => true,
        'created_by' => true,
        'modified_by' => true,
        'created_at' => true,
        'modified_at' => true,
        'products' => true,
        'transports' => true
    ];
}
