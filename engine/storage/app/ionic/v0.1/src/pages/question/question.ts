import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';

import { xelaRoute } from '../../app/xelaModule/xelaRoute';
import { xelaAudio } from '../../app/xelaModule/xelaAudio';
import { xelaToolbar } from '../../app/xelaModule/xelaToolbar';


/*
  Generated class for the Q page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-question',
  templateUrl: 'question.html',
  providers:  [ xelaRoute, xelaAudio, xelaToolbar ]
})
export class QuestionPage {
  private _question_length: number = 0;
  public id;
  public question_id;
  public question_type;
  public question_content;
  public choice_1;
  public choice_1_audio;
  public choice_2;
  public choice_2_audio;
  public choice_3;
  public choice_3_audio;
  public choice_4;
  public choice_4_audio;
  public correct_answer;
  public next_question;
  public menu_id;

  // Interface Rendering
  public isWidth100: boolean = null;
  public isWidth50: boolean = true;
  public isWrap: boolean = true;
  public isFlex: boolean = true;
  public isNextButton: boolean = false;
  public isEnableAnswer: boolean = false;

  public isChoice1: boolean = true;
  public isChoice2: boolean = true;
  public isChoice3: boolean = true;
  public isChoice4: boolean = true;

  constructor(private _toolbar: xelaToolbar, public navCtrl: NavController, public navParams: NavParams, public _route: xelaRoute, public _audioPlayer: xelaAudio) {
    this._question(this.navParams.get("_id")-1);
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad QPage');
  }

  ionViewWillLeave() {
    this._audioPlayer.unload();
  }

  private _question(_id): void {
    let questions: Array<any> = [
      {
        id: 1,
        question_id: "L3P36Q1",
        question_type: 1,
        question_content: "assets/img/P36/L3.3P36.jpg",
        choice_1: "ផែ",
        choice_1_audio: "L3P36_1.mp3",
        choice_2: "ផៃ",
        choice_2_audio: "L3P36_2.mp3",
        choice_3: "ផេះ",
        choice_3_audio: "L3P36_3.mp3",
        choice_4: "ថែ",
        choice_4_audio: "L3P36_4.mp3",
        correct_answer: 3,
        next_question: "L3P36Q2",
        menu_id: 1,
      },
      {
        id: 2,
        question_id: "L3P36Q2",
        question_type: 2,
        question_content: "L3P36_5.mp3",
        choice_1: "ដំបៅ",
        choice_1_audio: "L3P36_6.mp3",
        choice_2: "បបរ",
        choice_2_audio: "L3P36_7.mp3",
        choice_3: "សរសរ",
        choice_3_audio: "L3P36_8.mp3",
        choice_4: "ថៅកែ",
        choice_4_audio: "L3P36_5.mp3",
        correct_answer: 4,
        next_question: "L3P36Q3",
        menu_id: 1,
      },
      {
        id: 3,
        question_id: "L3P36Q3",
        question_type: 3,
        question_content: "សរសេរ",
        choice_1: "assets/img/P36/L3.1P36.jpg",
        choice_1_audio: "L3P36_9.mp3",
        choice_2: "assets/img/P36/L3.3P36.jpg",
        choice_2_audio: "L3P36_3.mp3",
        choice_3: "assets/img/P36/L3.4P36.jpg",
        choice_3_audio: "L3P36_11.mp3",
        choice_4: "assets/img/P36/L3.2P36.jpg",
        choice_4_audio: "L3P36_12.mp3",
        correct_answer: 3,
        next_question: "L3P36Q4",
        menu_id: 1,
      },
      {
        id: 4,
        question_id: "L3P36Q4",
        question_type: 1,
        question_content: "assets/img/P36/L3.2P36.jpg",
        choice_1: "បបរគ្រឿង",
        choice_1_audio: "L3P36_12.mp3",
        choice_2: "សរសើរ",
        choice_2_audio: "L3P36_13.mp3",
        choice_3: "បី",
        choice_3_audio: "L3P36_14.mp3",
        choice_4: "ដំបៅ",
        choice_4_audio: "L3P36_6.mp3",
        correct_answer: 1,
        next_question: "L3P36Q5",
        menu_id: 1,
      },
      {
        id: 5,
        question_id: "L3P36Q5",
        question_type: 2,
        question_content: "L3P36_13.mp3",
        choice_1: "ថែ",
        choice_1_audio: "L3P36_4.mp3",
        choice_2: "សរសើរ",
        choice_2_audio: "L3P36_13.mp3",
        choice_3: "ថៅកែ",
        choice_3_audio: "L3P36_5.mp3",
        choice_4: "សសរ",
        choice_4_audio: "L3P36_8.mp3",
        correct_answer: 2,
        next_question: "L3P36Q6",
        menu_id: 1,
      },
      {
        id: 6,
        question_id: "L3P36Q6",
        question_type: 3,
        question_content: "ថូ",
        choice_1: "assets/img/P36/L3.1P36.jpg",
        choice_1_audio: "L3P36_9.mp3",
        choice_2: "assets/img/P36/L3.2P36.jpg",
        choice_2_audio: "L3P36_12.mp3",
        choice_3: "assets/img/P36/L3.3P36.jpg",
        choice_3_audio: "L3P36_3.mp3",
        choice_4: "assets/img/P36/L3.4P36.jpg",
        choice_4_audio: "L3P36_8.mp3",
        correct_answer: 1,
        next_question: "L3P37Q1",
        menu_id: 1,
      },
      {
        id: 7,
        question_id: "L3P37Q1",
        question_type: 1,
        question_content: "assets/img/P37/L3.3P37.jpg",
        choice_1: "ភេ",
        choice_1_audio: "L3P37_1.mp3",
        choice_2: "សំពះ",
        choice_2_audio: "L3P37_2.mp3",
        choice_3: "ពពោះ",
        choice_3_audio: "L3P37_3.mp3",
        choice_4: "ពុំងា",
        choice_4_audio: "L3P37_4.mp3",
        correct_answer: 2,
        next_question: "L3P37Q2",
        menu_id: 1,
      },
      {
        id: 8,
        question_id: "L3P37Q2",
        question_type: 2,
        question_content: "L3P37_6.mp3",
        choice_1: "ធនាគារ",
        choice_1_audio: "L3P37_5.mp3",
        choice_2: "ធូធារ",
        choice_2_audio: "L3P37_6.mp3",
        choice_3: "ទើរ",
        choice_3_audio: "L3P37_7.mp3",
        choice_4: "ភើ",
        choice_4_audio: "L3P37_8.mp3",
        correct_answer: 2,
        next_question: "L3P37Q3",
        menu_id: 1,
      },
      {
        id: 9,
        question_id: "L3P37Q3",
        question_type: 3,
        question_content: "មី",
        choice_1: "assets/img/P37/L3.4P37.jpg",
        choice_1_audio: "L3P37_9.mp3",
        choice_2: "assets/img/P37/L3.1P37.jpg",
        choice_2_audio: "L3P37_10.mp3",
        choice_3: "assets/img/P37/L3.3P37.jpg",
        choice_3_audio: "L3P37_2.mp3",
        choice_4: "assets/img/P37/L3.2P37.jpg",
        choice_4_audio: "L3P37_5.mp3",
        correct_answer: 1,
        next_question: "L3P37Q4",
        menu_id: 1,
      },
      {
        id: 10,
        question_id: "L3P37Q4",
        question_type: 1,
        question_content: "assets/img/P37/L3.1P37.jpg",
        choice_1: "ទំនេរ",
        choice_1_audio: "L3P37_11.mp3",
        choice_2: "នំ",
        choice_2_audio: "L3P37_12.mp3",
        choice_3: "ទើរ",
        choice_3_audio: "L3P37_7.mp3",
        choice_4: "ទូ",
        choice_4_audio: "L3P37_10.mp3",
        correct_answer: 4,
        next_question: "L3P37Q5",
        menu_id: 1,
      },
      {
        id: 11,
        question_id: "L3P37Q5",
        question_type: 2,
        question_content: "L3P37_8.mp3",
        choice_1: "ពុំងា",
        choice_1_audio: "L3P37_4.mp3",
        choice_2: "ភើ",
        choice_2_audio: "L3P37_8.mp3",
        choice_3: "ទំនេរ",
        choice_3_audio: "L3P37_11.mp3",
        choice_4: "ពពោះ",
        choice_4_audio: "L3P37_3.mp3",
        correct_answer: 2,
        next_question: "L3P37Q6",
        menu_id: 1,
      },
      {
        id: 12,
        question_id: "L3P37Q6",
        question_type: 3,
        question_content: "ធនាគារ",
        choice_1: "assets/img/P37/L3.3P37.jpg",
        choice_1_audio: "L3P37_2.mp3",
        choice_2: "assets/img/P37/L3.2P37.jpg",
        choice_2_audio: "L3P37_5.mp3",
        choice_3: "assets/img/P37/L3.4P37.jpg",
        choice_3_audio: "L3P37_9.mp3",
        choice_4: "assets/img/P37/L3.1P37.jpg",
        choice_4_audio: "L3P37_10.mp3",
        correct_answer: 2,
        next_question: "RootPage",
        menu_id: 1,
      },
    ];

    console.log("xelaController: QuestionPage: Displaying Question -> ", questions[_id]);
    this.id = questions[_id]["id"];
    this.question_id = questions[_id]["question_id"];
    this.question_type = questions[_id]["question_type"];
    this.question_content = questions[_id]["question_content"];
    this.choice_1 = questions[_id]["choice_1"];
    this.choice_1_audio = questions[_id]["choice_1_audio"];
    this.choice_2 = questions[_id]["choice_2"];
    this.choice_2_audio = questions[_id]["choice_2_audio"];
    this.choice_3 = questions[_id]["choice_3"];
    this.choice_3_audio = questions[_id]["choice_3_audio"];
    this.choice_4 = questions[_id]["choice_4"];
    this.choice_4_audio = questions[_id]["choice_4_audio"];
    this.correct_answer = questions[_id]["correct_answer"];
    this.next_question = questions[_id]["next_question"];
    this.menu_id = questions[_id]["menu_id"];

    this._question_length = questions.length;

    setTimeout(() => {
      this._play_question(questions[_id]);
    }, 1500);
  }

  private enableAnswerButton() {
    let waiting = setInterval(() => {
      if(this._audioPlayer.isFinishedPlaying == true) {
        console.log("Waiting for Audio Playback: Finished -> ", this._audioPlayer.isFinishedPlaying);
        this.isEnableAnswer = true;
        clearInterval(waiting);
      }else{
        console.log("Waiting for Audio Playback: Finished -> ", this._audioPlayer.isFinishedPlaying);
        this.isEnableAnswer = false;
      }
    }, 1000);
  }

  private _play_question(options: any): boolean {
    this.isEnableAnswer = false;
    let opt;
    if (this.question_type == 2) {
      opt = {
        u_id: 'Media1',
        path: 'assets/audio/general/M'+this.question_type+'.mp3'
      };
      this._audioPlayer.play(opt);

      setTimeout(() => {
        opt = {
          u_id: 'Media2',
          path: 'assets/audio/lessons/'+options["choice_"+options["correct_answer"]+"_audio"]
        };
        this._audioPlayer.play(opt);
        this.enableAnswerButton();
      }, 2500);
    }else{
      opt = {
        u_id: 'Media1',
        path: 'assets/audio/general/M'+this.question_type+'.mp3'
      };
      this._audioPlayer.play(opt);
      this.enableAnswerButton();
    }

    return true;
  }

  public answer(options): boolean {
    if (this.isEnableAnswer == false || this.isNextButton == true) {
      return false;
    }

    this.isEnableAnswer = false;
    this._render(options);

    let question = {
      id: this.id,
      question_id: this.question_id,
      question_type: this.question_type,
      question_content: this.question_content,
      choice_1: this.choice_1,
      choice_1_audio: this.choice_1_audio,
      choice_2: this.choice_2,
      choice_2_audio: this.choice_2_audio,
      choice_3: this.choice_3,
      choice_3_audio: this.choice_3_audio,
      choice_4: this.choice_4,
      choice_4_audio: this.choice_4_audio,
      correct_answer: this.correct_answer,
      next_question: this.next_question,
      menu_id: this.menu_id,
    }

    let opt = {
      u_id: 'Media1',
      path: 'assets/audio/lessons/'+question["choice_"+options+"_audio"]
    };
    this._audioPlayer.play(opt);

    if(options == this.correct_answer){
      console.log("Answer Is Correct!");
      opt = {
        u_id: 'Media2',
        path: 'assets/audio/general/Yes.mp3'
      };
    }else {
      console.log("Answer Is Incorrect!");
      opt = {
        u_id: 'Media2',
        path: 'assets/audio/general/No.mp3'
      };
    }
    setTimeout(() => {
      this._audioPlayer.play(opt);
    }, 1200);
    setTimeout(() => {
      if(options == this.correct_answer){
        this.isNextButton = true;
      }else{
        this._render(99);
        this.isNextButton = false;
        this.isEnableAnswer = true;
      }
    }, 3000);
    return true;
  };

  public replay() {
    if (this.isEnableAnswer == false || this.isNextButton == true) {
      return false;
    }
    this._render(99);
    this.isNextButton = false;

    let question = {
      id: this.id,
      question_id: this.question_id,
      question_type: this.question_type,
      question_content: this.question_content,
      choice_1: this.choice_1,
      choice_1_audio: this.choice_1_audio,
      choice_2: this.choice_2,
      choice_2_audio: this.choice_2_audio,
      choice_3: this.choice_3,
      choice_3_audio: this.choice_3_audio,
      choice_4: this.choice_4,
      choice_4_audio: this.choice_4_audio,
      correct_answer: this.correct_answer,
      next_question: this.next_question,
      menu_id: this.menu_id,
    };

    this._play_question(question);
  }

  private _render(choice) {
    // Is use for Enable / Disable Element on the HTML Page

    if (choice == 1) {
      this.isChoice2 = false;
      this.isChoice3 = false;
      this.isChoice4 = false;
      console.log("_render(choice) -> ", choice);
    }else if(choice == 2) {
      this.isChoice1 = false;
      this.isChoice3 = false;
      this.isChoice4 = false;
      console.log("_render(choice) -> ", choice);
    }else if(choice == 3) {
      this.isChoice1 = false;
      this.isChoice2 = false;
      this.isChoice4 = false;
      console.log("_render(choice) -> ", choice);
    }else if(choice == 4) {
      this.isChoice1 = false;
      this.isChoice2 = false;
      this.isChoice3 = false;
      console.log("_render(choice) -> ", choice);
    }else if(choice == 0) {
      this.isChoice1 = false;
      this.isChoice2 = false;
      this.isChoice3 = false;
      this.isChoice4 = false;
      this.isWidth100 = null;
      console.log("_render(choice) -> ", choice);
      return true;
    }else if(choice == 99) { // 99 = Reset
      this.isChoice1 = true;
      this.isChoice2 = true;
      this.isChoice3 = true;
      this.isChoice4 = true;
      this.isWrap = true;
      this.isWidth100 = null;
      this.isWidth50 = true;
      console.log("_render(choice) -> ", choice);
      return true;
    }
    this.isWidth100 = true;
    this.isWidth50 = null;
    this.isWrap = null;
    this.isFlex = null;
    console.log("_render(choice) -> Ending", choice);
  }

  public question_next(_id) {
    console.log("this._question_length", this._question_length);
    if (_id > this._question_length) {
      this.isEnableAnswer = true;
      this.popToRoot();
      return true;
    }
    this._route.go(
      QuestionPage, {
        _id: _id
      }
    );
  }

  public popToRoot() {
    if (this.isEnableAnswer == false ) {
      return false;
    }
    this._route.popToRoot();
  }

  public exit() {
    this._toolbar.exit();
  }

}

// let questions: Array<any> = [
//   {
//     id: 1,
//     question_id: "L3P36Q1",
//     question_type: 1,
//     question_content: "assets/img/P36/L3.3P36.jpg",
//     choice_1: "ផែ",
//     choice_1_audio: "L3P36_1.mp3",
//     choice_2: "ផៃ",
//     choice_2_audio: "L3P36_2.mp3",
//     choice_3: "ផេះ",
//     choice_3_audio: "L3P36_3.mp3",
//     choice_4: "ថែ",
//     choice_4_audio: "L3P36_4.mp3",
//     correct_answer: 3,
//     next_question: "L3P36Q2",
//     menu_id: 1,
//   },
// ];
