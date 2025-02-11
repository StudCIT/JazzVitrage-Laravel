<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Nomination;
use App\Models\Quotes;
use App\Models\Contacts;
use App\Models\ContactsItems;

class InfoController extends Controller
{
    protected $nominationStorage = '/img/nominations/';

    function getAllInfo() {
        $info = DB::select('select logo_section.*, position_section.*, hymn_section.*, master_class.* from logo_section, position_section, hymn_section, master_class');
        $info[0]->provisions_text = htmlspecialchars_decode($info[0]->provisions_text);
        $info[0]->description = htmlspecialchars_decode($info[0]->description);
        $info[0]->ticker = htmlspecialchars_decode($info[0]->ticker);
        $info[0]->description_master = htmlspecialchars_decode($info[0]->description_master);
        $contact = Contacts::with('contactsItems')->get();
        $nominations = Nomination::get();
        return response()->json([
            'info' => $info,
            'contact' => $contact,
            'nominations' => $nominations
        ]);
    }
    public function getPersonalDoc()
    {
        $data = DB::select('select personal_data, compress_url from position_section');
        return response()->json(['personal' => $data[0]->personal_data, 'compress_url' => $data[0]->compress_url]);
    }
    public function postContact(Request $request)
    {
        if($request->id) {
            $contacts = ContactsItems::find($request->id);
            $contacts->contact_section_id = $request->contact_section_id;
        } else {
            $contacts = new ContactsItems;
            $contacts->contact_section_id = 2;
        }

        $contacts->contact_title = $request->contact_title;
        $contacts->contact = $request->contact;
        $contacts->save();
        return response()->json([
            "id" => $contacts->contact_items_id,
            "contact_section_id" => $contacts->contact_section_id,
        ]);
    }
    public function postSocial(Request $request)
    {
        if($request->id) {
            $contacts = ContactsItems::find($request->id);
            $contacts->contact_section_id = $request->contact_section_id;
        } else {
            $contacts = new ContactsItems;
            $contacts->contact_section_id = 3;
        }
        $contacts->contact_title = $request->contact_title;
        $contacts->contact = $request->contact;
        $contacts->save();
        return response()->json([
            "id" => $contacts->contact_items_id,
            "contact_section_id" => $contacts->contact_section_id,
        ]);
    }
    public function deleteContact($id)
    {
        $contacts = ContactsItems::find($id);
        $contacts->delete();
    }
    public function postInfo(Request $request)
    {
        $res = DB::update('update '.$request->table.' set '.$request->row.' = "'.htmlspecialchars($request->value).'" where id = 1');
    }
    public function postInfoFile(Request $request)
    {
        $name = $request->file->getClientOriginalName();
        $directorty = '/'.$request->type;
        $request->file->move(public_path().$directorty, $name);
        $res = DB::update('update '.$request->table.' set '.$request->row.' = "'.$directorty.'/'.$name.'" where id = 1');
    }

    // CRUD Цитати
    public function getQuotes()
    {
        $quotes = new Quotes;
        $data = Quotes::get();
        return response()->json($data);
    }
    public function postQuote(Request $request)
    {
        $quotes = new Quotes;
        $quotes->text = $request->text;
        $quotes->save();
        return response()->json(["quote_id" => $quotes->quote_id]);
    }
    public function putQuote(Request $request)
    {
        $quotes = Quotes::find($request->id);
        $quotes->text = $request->text;
        $quotes->save();
    }
    public function deleteQuote($id)
    {
        $quotes = Quotes::find($id);
        $quotes->delete();
    }

    function putNomination(Request $request, $id) {
        $model = Nomination::find($id);
        $name = $this->nominationStorage.uniqid().'.'.$request['logo']->getClientOriginalExtension();
        $request['logo']->move(public_path().$this->nominationStorage, $name);
        $model->logo = $name;
        $model->save();
    }

}
