<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\contactReplay;
use App\Models\Contact;
use App\Models\Replay;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{

    public function index() {

        $keyword    = request()->input('keyword') != null ? request()->input('keyword') : null;
        $status     = request()->input('status') != null && in_array(request()->input('status'),['1', '0']) ? request()->input('status') : 'all';
        $sort_by    = request()->input('sort_by') != null && in_array(request()->input('sort_by'),['created_at', 'status', 'name', 'title']) ? request()->input('sort_by') : 'created_at';
        $order_by   = request()->input('order_by') != null && in_array(request()->input('order_by'),['asc', 'desc']) ? request()->input('order_by') : 'desc';
        $limit_by   = request()->input('limit_by') != null && in_array(request()->input('limit_by'),['10', '20', '50' ,'100']) ? request()->input('limit_by') : '20';

        $contacts = Contact::query();

        if($keyword != null) {
            $contacts = $contacts->search($keyword, null, true);
        }   
        if($status !== 'all') {
            $contacts = $contacts->where('status', $status);
        }
        $contacts = $contacts->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('backend.contact-us.contact-us', ['contacts' => $contacts]);
    }
    
    public function replay($id) {

        $contact = Contact::where('id',$id)->first();
        if($contact) {
            return view('backend.contact-us.replay', ['contact' => $contact]);
        }else {
            return view('backend.404');
        }

    }

    public function replaySend(Request $request, $id) {

        $contact = Contact::where('id',$id)->where('status',0)->first();
        if($contact) {

            $validator = Validator::make($request->all(),[
                'replay' => 'required|string:20'
            ]);

            if($validator->fails()) {
                return redirect()->route('admin.contact.replay', $contact->id)->withInput()->withErrors($validator);
            }

            $data['replay'] = $request->input('replay');
            $data['contact_id'] = $id;
            $replay = Replay::create($data);

            if($replay) {
                //تم الرد على الرسالة وحفظ الرد في قاعدة البيانات
                $contact->update(['status' => 1]);

                try {
                    Mail::to($contact->email)->send( new contactReplay($contact, $request->input('replay')));
                    // التأكد من أنه تم إرسال الرسالة الى المستخدم
                    $replay->update(['status' => 1]);

                    return redirect()->route('admin.contact.replay', $id)->with([
                        'message' => 'Your replay sent successfully',
                        'alert-type' => 'success',
                    ]);
                }catch(Exception $e) {
                    return redirect()->route('admin.contact.replay', $id)->with([
                        'message' => 'Some thing was wrong! try later ',
                        'alert-type' => 'danger',
                    ]);
                }

            }else {
                return redirect()->route('admin.contact.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }

        }else {
            return view('backend.404');
        }

    }

    public function replayResend(Request $request, $id) {

        $replay = Replay::where('id', $id)->where('status', 0)->first();
        if($replay) {
            try {
                Mail::to($replay->contact->email)->send( new contactReplay($replay->contact, $replay->replay));
                // التأكد من أنه تم إرسال الرسالة الى المستخدم
                $replay->update(['status' => 1]);

                return redirect()->route('admin.contact.replay', $replay->contact->id)->with([
                    'message' => 'Your replay sent successfully',
                    'alert-type' => 'success',
                ]);
            }catch(Exception $e) {
                return redirect()->route('admin.contact.replay', $replay->contact->id)->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }
        }else {
            return view('backend.404');
        }

    }

    public function destroy($id) {

        $contact = Contact::where('id',$id)->first();
        if($contact) {
            if($contact->delete()) {
                return redirect()->route('admin.contact.all')->with([
                    'message' => 'The message deleted successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.contact.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }
        }else {
            return view('backend.404');
        }
    }

}
