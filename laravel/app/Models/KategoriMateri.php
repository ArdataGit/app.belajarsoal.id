<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\PaketMst;
use App\Models\PaketZoom;
use App\Models\PaketMateri;
use App\Models\PaketDtl;

class KategoriMateri extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "kategori_materi";
    protected $guarded = ["id"];


    static public function kategoris($roots=true){
        $ks     = static::get();
        $ret    = [];
        if($roots)$ret[0] = [];
        foreach($ks as $k){
            $ret[$k->id] = [
                'parent_id'=> $k->parent_id,
                'name'=> $k->name,
                'keterangan'=> $k->keterangan,
                'items'=> [],
            ];
        }
        $root = [];
        foreach($ks as $k){
            $pid = $k->parent_id;
            if(!$pid || !isset($ret[$pid])){
                $root[] = $k->id;
                if($roots)$ret[0][] = $k->id;
            }else{
                $ret[$pid]['items'][] = $k->id;
            }
        }
        if(!$roots){
            foreach($root as $k)unset($ret[$k]);
        }
        return $ret;
    }

    static public function kategoris_parents($roots=true){
        $ret = [];
        $ks  = static::kategoris($roots);
        foreach($ks as $i=>&$k){
            $ret[$i] = $k;
            $ret[$i]['parents'] = [];
        }
        foreach($ks as $i=>$k){
            $pid = $k['parent_id'];
            while(true){
                if($pid && isset($ret[$pid])){
                    $ret[$i]['parents'][] = $pid;
                    $pid = $ret[$pid]['parent_id'];
                }else{
                    break;
                }
            }
        }
        return $ret;
    }

    static private function _add_items($items, &$kategoris, &$ret){
        foreach($items as $id){
            $ret[$id] = $kategoris[$id];
            if($ret[$id]['items']){
                static::_add_items($ret[$id]['items'], $kategoris, $ret);
            }
        }
    }

    static public function kategoris_by_name($name){
        $kp = 0;
        $ks = static::kategoris();        
        foreach($ks[0] as $id){
            if($ks[$id]['name']===$name){
                $kp = $id;
                break;
            }
        }

        $ret    = [];
        $ret[0] = [];
        if($kp && $ks[$kp]['items']){
            $ret[0] = $ks[$kp]['items'];
            static::_add_items($ks[$kp]['items'], $ks, $ret);
        }

        return $ret;

    }

    static public function kategoris_by_pakets(&$pakets, $kid, &$parents){
        $ret = [];
        $parents = [];
        if($pakets){
            
            $kategoris = static::kategoris_parents(false);

            if($kid && isset($kategoris[$kid])){
                
                $parents[$kid] = $kategoris[$kid];
                foreach($kategoris[$kid]['parents'] as $pid){
                    if(isset($kategoris[$pid])){
                        $parents[$pid] = $kategoris[$pid];
                    }
                }

                if($kategoris[$kid]['items']){
                    $ps  = $pakets;
                    $pin = [];
                    $pakets = [];
                    foreach($ps as $p){
                        $pin[] = $p->id;
                        $pakets[$p->id] = $p;
                    }
                    $kats    = [];
                    $materis = PaketMateri::whereIn('fk_paket_mst', $pin)->get();
                    $details = PaketDtl::whereIn('fk_paket_mst', $pin)->get();
                    $zooms   = PaketZoom::whereIn('fk_paket_mst', $pin)->get();
                    foreach($materis as $v){
                        if($v->kategori_id && isset($kategoris[$v->kategori_id])){
                            if(($kategoris[$v->kategori_id]['parent_id']===$kid) || in_array($kid, $kategoris[$v->kategori_id]['parents'])){
                                if(isset($pakets[$v->fk_paket_mst]))unset($pakets[$v->fk_paket_mst]);
                                $kats[$v->kategori_id] = [];
                            }
                        }
                    }
                    foreach($details as $v){
                        if($v->kategori_id && isset($kategoris[$v->kategori_id])){
                            if(($kategoris[$v->kategori_id]['parent_id']===$kid) || in_array($kid, $kategoris[$v->kategori_id]['parents'])){
                                if(isset($pakets[$v->fk_paket_mst]))unset($pakets[$v->fk_paket_mst]);
                                $kats[$v->kategori_id] = [];
                            }
                        }
                    }
                    foreach($zooms as $v){
                        if($v->kategori_id && isset($kategoris[$v->kategori_id])){
                            if(($kategoris[$v->kategori_id]['parent_id']===$kid) || in_array($kid, $kategoris[$v->kategori_id]['parents'])){
                                if(isset($pakets[$v->fk_paket_mst]))unset($pakets[$v->fk_paket_mst]);
                                $kats[$v->kategori_id] = [];
                            }
                        }
                    }
                    foreach($kats as $k=>$v){
                        if($kategoris[$k]['parent_id']===$kid){
                            $ret[$k] = $kategoris[$k];
                        }else{
                            foreach($kategoris[$kid]['items'] as $i){
                                if($i===$k){
                                    $ret[$i] = $kategoris[$i];
                                }
                            }
                        }
                    }
                }else{
                    $ps  = $pakets;
                    $pin = [];
                    foreach($pakets as $p){
                        $pin[] = $p->id;
                        $ps[$p->id] = $p;
                    }
                    $pakets = [];        
                    $kats    = [];
                    $materis = PaketMateri::whereIn('fk_paket_mst', $pin)->where('kategori_id', $kid)->get();
                    $details = PaketDtl::whereIn('fk_paket_mst', $pin)->where('kategori_id', $kid)->get();
                    $zooms   = PaketZoom::whereIn('fk_paket_mst', $pin)->where('kategori_id', $kid)->get();
                    foreach($materis as $v){
                        $pakets[$v->fk_paket_mst] = $ps[$v->fk_paket_mst];
                    }
                    foreach($details as $v){
                        $pakets[$v->fk_paket_mst] = $ps[$v->fk_paket_mst];
                    }
                    foreach($zooms as $v){
                        $pakets[$v->fk_paket_mst] = $ps[$v->fk_paket_mst];
                    }
                }
            }else{
                $ps  = $pakets;
                $pin = [];
                $pakets = [];
                foreach($ps as $p){
                    $pin[] = $p->id;
                    $pakets[$p->id] = $p;
                }    
                $kats    = [];
                $materis = PaketMateri::whereIn('fk_paket_mst', $pin)->get();
                $details = PaketDtl::whereIn('fk_paket_mst', $pin)->get();
                $zooms   = PaketZoom::whereIn('fk_paket_mst', $pin)->get();
                foreach($materis as $v){
                    if($v->kategori_id && isset($kategoris[$v->kategori_id])){
                        if(isset($pakets[$v->fk_paket_mst]))unset($pakets[$v->fk_paket_mst]);
                        if($kategoris[$v->kategori_id]['parents']){
                            foreach($kategoris[$v->kategori_id]['parents'] as $pid){
                                if(isset($kategoris[$pid]))$kats[$pid] = [];
                            }    
                        }else{
                            $kats[$v->kategori_id] = [];
                        }
                    }
                }
                foreach($details as $v){
                    if($v->kategori_id && isset($kategoris[$v->kategori_id])){
                        if(isset($pakets[$v->fk_paket_mst]))unset($pakets[$v->fk_paket_mst]);
                        if($kategoris[$v->kategori_id]['parents']){
                            foreach($kategoris[$v->kategori_id]['parents'] as $pid){
                                if(isset($kategoris[$pid]))$kats[$pid] = [];
                            }    
                        }else{
                            $kats[$v->kategori_id] = [];
                        }
                    }
                }
                foreach($zooms as $v){
                    if($v->kategori_id && isset($kategoris[$v->kategori_id])){
                        if(isset($pakets[$v->fk_paket_mst]))unset($pakets[$v->fk_paket_mst]);
                        if($kategoris[$v->kategori_id]['parents']){
                            foreach($kategoris[$v->kategori_id]['parents'] as $pid){
                                if(isset($kategoris[$pid]))$kats[$pid] = [];
                            }    
                        }else{
                            $kats[$v->kategori_id] = [];
                        }
                    }
                }
                foreach($kats as $k=>$v){
                    if(!$kategoris[$k]['parent_id'] || !$kategoris[$k]['parents'])$ret[$k] = $kategoris[$k];
                }
            }
        }
        if($parents)$parents = array_reverse($parents, true );
        return $ret;
    }

    static function kategori_tree(){
        static $kategoris = NULL;

        if(is_array($kategoris))return $kategoris;

        $ks = static::get();

        $i   = 0;
        $ret = [];
        foreach($ks as $k){
            $ret[$k->id] = [
                'root_id'=> 0,
                'parent_id'=> $k->parent_id,
                'name'=> $k->name,
                'keterangan'=> $k->keterangan,
                'parents'=> [],
                'items'=> [],
            ];            
            $i++;
        }

        $roots = [];
        foreach($ks as $k){
            $id  = $k->id;
            $pid = $k->parent_id;
            if(isset($ret[$pid])){
                $ret[$pid]['items'][] = $id;
                while(isset($ret[$pid])){
                    $ret[$id]['root_id'] = $pid;
                    $ret[$id]['parents'][] = $pid;
                    $pid = $ret[$pid]['parent_id'];
                }    
            }else{
                $roots[] = $id;
            }
        }

        $ret[0] = $roots;

        $kategoris = $ret;
        return $ret;
    }
    
    
    static function kategori_trees(){
        static $kategoris = NULL;

        if(is_array($kategoris))return $kategoris;

        $ks = static::get();

        $i   = 0;
        $ret = [];
        foreach($ks as $k){
            $ret[$k->id] = [
                'root_id'=> 0,
                'parent_id'=> $k->parent_id,
                'name'=> $k->name,
                'keterangan'=> $k->keterangan,
                'parents'=> [],
                'items'=> [],
            ];            
            $i++;
        }

        $roots = [];
        foreach($ks as $k){
            $id  = $k->id;
            $pid = $k->parent_id;
            if(isset($ret[$pid])){
                $ret[$pid]['items'][] = $id;
                while(isset($ret[$pid])){
                    $ret[$id]['root_id'] = $pid;
                    $ret[$id]['parents'][] = $pid;
                    $pid = $ret[$pid]['parent_id'];
                }    
            }else{
                $roots[] = $id;
            }
        }

        $ret[0] = $roots;

        $kategoris = $ret;
        return $ret;
    }

    private static function _materi_kategoris(&$materis, &$kategoris, $kid){
        $ret = [];
        foreach($kategoris[$kid]['items'] as $id){
            foreach($materis as $m){
                if($m->kategori_id && isset($kategoris[$m->kategori_id])){                    
                    if($id == $m->kategori_id){
                        $ret[$id][0][] = $m;
                    }elseif(in_array($id, $kategoris[$m->kategori_id]['parents'])){
                        $ret[$id] = static::_materi_kategoris($materis, $kategoris, $id);
                    }
                }
            }
        }
        return $ret;
    }
    
    
    static function materi_kategoris(&$materis, &$kategoris, $kategori){

        $root = 0;

        foreach($kategoris[0] as $id){
            if(($kategoris[$id]['name']===$kategori)){
                $root = $id;
                break;
            }        
        }

        if(!$root)return [];

        $ret = static::_materi_kategoris($materis, $kategoris, $root);

        if(!$ret)$ret = [];

        foreach($materis as $m){
            if(!$m->kategori_id || !isset($kategoris[$m->kategori_id])){
                $ret[0][] = $m;
            }
        }

        return $ret;
    }
    

    static function materi_array(){
        $ret  = [];
        $args = func_get_args();
        foreach($args as $arg){
            foreach($arg as $m){
                $ret[$m->id] = $m;
            }                
        }
        return $ret;
    }

}
