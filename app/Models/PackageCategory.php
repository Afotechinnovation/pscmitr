<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PackageCategory
 *
 * @property int $id
 * @property int $package_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @property string|null $path
 * @property int|null $folder_id
 * @property string|null $type FOLDER
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCategory whereUserId($value)
 */
class PackageCategory extends Model
{
    use HasFactory;

    public function package_videos()
    {
        return $this->hasMany(PackageVideo::class,'category_id','id');
    }

    public function package_study_materials()
    {
        return $this->hasMany(PackageStudyMaterial::class,'category_id','id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
