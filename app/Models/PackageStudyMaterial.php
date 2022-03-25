<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PackageStudyMaterial
 *
 * @property int $id
 * @property int $package_id
 * @property int $category_id
 * @property int $document_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageStudyMaterial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PackageStudyMaterial extends Model
{
    use HasFactory;

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function package_category()
    {
        return $this->belongsTo(PackageCategory::class,'category_id','id');
    }

    public function document()
    {
        return $this->belongsTo(Node::class,'document_id','id');
    }
}
