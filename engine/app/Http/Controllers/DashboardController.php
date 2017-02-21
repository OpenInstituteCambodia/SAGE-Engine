<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    public function parseXML(Request $request) {

      $xmlfile = $request->file('xmlfile');
      $path = $request->file('xmlfile')->store('xml', 'public');

      $xml = new \DOMDocument('1.0', 'utf-8');
      $xml->load(storage_path('app/public/').$path);
      $xpath = new \DOMXPath($xml);

      $rootElement;
      if ($xpath->query('/elements')->length > 0) {
        $rootElement = '/elements/unit';
      }else {
        $rootElement = '/unit';
      }

      for ($i=0; $i < $xpath->query($rootElement)->length ; $i++) {
        // $xpath->evaluate('string('.$rootElement.')');
      }

      return view('xml', compact('rootElement', 'xpath', 'template_m1'));
    }

    public function getTemplate($style) {

      if ($style == 'M1' || $style == 'M2') {
        $template = <<<EOT

        <div id="{{placeholder_unit_id}}" audio-1="{{placeholder_pre-audio}}" audio-2="{{placeholder_audio}}" *ngIf="question_id == {{placeholder_unit_id}}" >
          <div [attr.overlay]="isNextButton"></div>

          <ion-card sticky-center m [ngStyle]="{'background': 'url('{{placeholder_audio_image}}')'}"></ion-card>

          <ion-grid [attr.is-next]="isNextButton" *ngIf="isNextButton">
            <ion-row [attr.wrap]="isWrap" >
              <ion-col width-100>
                <button ion-button block color="secondary" isNextButton (click)="question_next({{placeholder_next}})">
                  <ion-icon name="arrow-forward"></ion-icon>
                </button>
              </ion-col>
            </ion-row>
          <ion-grid>

          <ion-grid sticky-bottom choice-correct-answer="{{placeholder_correct_answer}}" choice-wrong-answer="{{placeholder_wrong_answer}}">
            <ion-row [attr.wrap]="isWrap" M12>
                <ion-col [attr.width-50]="isWidth50" [attr.width-100]="isWidth100" *ngIf="isChoice1">
                  <button ion-button block color-1 choice-1-audio="{{placeholder_choice_1_audio}}" (click)="answer({{placeholder_correct}}, 1)">{{placeholder_choice_1_text}}</button>
                </ion-col>
                <ion-col [attr.width-50]="isWidth50" [attr.width-100]="isWidth100" *ngIf="isChoice2">
                  <button ion-button block color-2 choice-2-audio="placeholder_choice_2_audio" (click)="answer({{placeholder_correct}}, 2)">{{placeholder_choice_2_text}}</button>
                </ion-col>
                <ion-col [attr.width-50]="isWidth50" [attr.width-100]="isWidth100" *ngIf="isChoice3">
                  <button ion-button block color-3 choice-3-audio="placeholder_choice_3_audio" (click)="answer({{placeholder_correct}}, 3)">{{placeholder_choice_3_text}}</button>
                </ion-col>
                <ion-col [attr.width-50]="isWidth50" [attr.width-100]="isWidth100" *ngIf="isChoice4">
                  <button ion-button block color-4 choice-4-audio="placeholder_choice_4_audio" (click)="answer({{placeholder_correct}}, 4)">{{placehoder_choice_4_text}}</button>
                </ion-col>
              </ion-row>
          </ion-grid>
        </div>

EOT;
      }

      return $template;
    }

}
