<?php

namespace App\Http\Controllers;

use Auth;
use App\Pasta;
use App\Accesstime;
use App\Linguist;
use Illuminate\Http\Request;

class PastaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function pastas_public($timer) 
    {
	return $this->pastas_public_filter($timer,'');
    }


    private function pastas_public_filter($timer,$txt) 
    {
        return Pasta::where([
                                ['is_listed','=','1'],
                                ['is_private','=','0'],
                           ])->where(
                                function($q) use ($timer)
                                {
                                    $q->where('up_to','>=',$timer)
                                    ->orWhereNull('up_to');
                                }
		 	    )->where(
				function($q) use ($txt)
				{
				    $q->where('body','LIKE',"%$txt%")
					->orWhere('hash','LIKE',"%$txt%");
				}
                            )->orderBy('id','desc')->take(10)->get();
    }


    private function pastas_priv_filter($id,$timer,$txt)
    {
	return Pasta::where([
			       ['user_id','=',$id],
			   ])->where(
				function($q) use ($timer)
				{
                                    $q->where('up_to','>=',$timer)  
                                    ->orWhereNull('up_to');
                                }
			    )->where(
				function($q) use ($txt)
				{
				    $q->where('hash','LIKE',"%$txt%")
				      ->orWhere('body','LIKE',"%$txt%");
				}
			    )->orderBy('id','desc')->paginate(10);
    }

    private function pastas_priv($id,$timer)
    {
/*        return Pasta::where([
                               ['user_id','=',$id],
                           ])->where(
                                function($q) use ($timer)
                                {
                                    $q->where('up_to','>=',$this->timer)
                                    ->orWhereNull('up_to');
                                })
                           ->orderBy('id','desc')->paginate(10);
*/
	return $this->pastas_priv_filter($id,$timer,'');  
     }
 

    public function index()
    {
	$ctime=time();
	$vars['pastas']=$this->pastas_public($ctime);

        if(Auth::check())
                $vars['pastas_priv']=$this->pastas_priv(Auth::id(),$ctime);

        return view('welcome',$vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	$ctime = time();
	$timers = Accesstime::all();
	$langs = Linguist::all();

	$vars=array();

	if(Auth::check())
		$vars['pastas_priv']=$this->pastas_priv(Auth::id(),$ctime);

	$vars['pastas']=$this->pastas_public($ctime);
	$vars['timers']=$timers;
	$vars['langs']=$langs;
        return view('upload',$vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request,[
				 'body'=>'required',
				]);

	$record=new Pasta;
        $record->body=$request->body;
       	$record->user_id=(Auth::id()) ? Auth::id() : NULL;
	$record->is_listed=($request->has('is_listed')) ? 1 : 0;
	$record->is_private=($request->has('is_private')) ? 1 : 0;
	$record->lang_id=($request->ling) ? $request->ling : NULL;

	$record->up_to=($request->timer) ? time()+$request->timer : null;

/*	if ($request->timer == 0)
		$record->up_to=null;
	else 
	{
		$cur_time=now()->timestamp;
	}
*/
	$record->save();
	
	//Pasta::create($request->all());

	return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	$ctime = time();
	$lang=null;
        $vars['pastas']=$this->pastas_public($ctime);

        if(Auth::check())
                $vars['pastas_priv']=$this->pastas_priv(Auth::id(),$ctime);

	$user_id=(Auth::id()) ? Auth::id() : 0;
	$vars['result']= Pasta::where([ 
					['is_private','=',0],
					['hash','=',$id]
				     ])
		      		     ->orWhere(function ($query) use ($user_id,$id) {
					      $query->where([
								['user_id','=',$user_id],
								['hash','=',$id]
				              		   ]);
						})->first();
	
	
	if($vars['result']!=null)
	{
		$lang=Linguist::where('id',$vars['result']->lang_id)->first();
	}
	if ($lang!=null)
		$vars['lang']=$lang->name;
	return view('show',$vars);
    }

    public function search(Request $request) 
    {
	//dd($request);
        $txt=$request->s_string;
	$ctime=time();

	error_log($txt);
	if( Auth::check() )
	{
	    if (strlen($txt)==0) 
		$vars['result']=NULL;
	    else
	        $vars['result']=$this->pastas_private_filter(Auth::id(),$ctime,$txt);
	    $vars['pastas_priv']=$this->pastas_priv(Auth::id(),$ctime);
	}
	else 
	{
	    if (strlen($txt)==0) 
		$vars['result']=NULL;
	    else
	        $vars['result']=$this->pastas_public_filter($ctime,$txt);	    
            $vars['pastas']=$this->pastas_public($ctime);
	}
	//dd($vars);
	return view('search',$vars);
    }
}
