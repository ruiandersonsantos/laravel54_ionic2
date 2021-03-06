import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import {Subject} from "rxjs/Subject";
import {NavController} from "ionic-angular";

/*
  Generated class for the Redirector provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class Redirector {

  subject = new Subject;

  config(navCtr: NavController, link = 'LoginPage'){
    this.subject.subscribe(()=>{
      setTimeout(()=>{
        navCtr.setRoot(link);
      });

    });
  }

  redirector(){
      this.subject.next();
  }

}
