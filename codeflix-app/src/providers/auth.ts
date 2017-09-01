import { Injectable } from '@angular/core';
import 'rxjs/add/operator/map';
import {JwtClient} from "./jwt-client";
import {JwtPayload} from "../models/jwt-payload";
import 'rxjs/add/operator/toPromise';
import {Facebook, FacebookLoginResponse} from "@ionic-native/facebook";
import {UserResource} from "./resources/user-resource";
import {BehaviorSubject} from "rxjs/BehaviorSubject";

/*
  Generated class for the Auth provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class Auth {

  private _user = null;
  private _userSubject = new BehaviorSubject(null);

  constructor(public jwtCliente: JwtClient,
              public fb: Facebook,
              public userResource: UserResource) {

  }

  userSubject():BehaviorSubject<Object>{
      return this._userSubject;
  }

  user():Promise<Object>{

    return new Promise((resolve)=>{

        if(this._user){
        resolve(this._user);
      }

      this.jwtCliente.getPayload().then((payload:JwtPayload) =>{

        if(payload){

            this._user = payload.user;
            this._userSubject.next(this._user);
        }
          resolve(this._user);

      })
    });
  }

  check():Promise<Boolean>{
      return this.user().then( user =>{
          return user !== null;
      })
  }

  login({email,password}):Promise<Object>{
    return this.jwtCliente.acessToken({email, password})
        .then(()=>{
            return this.user();
        })
  }

  loginFacebook():Promise<string>{
     return this.fb.login(['email'])
          .then((response: FacebookLoginResponse) =>{
            let acessToken = response.authResponse.accessToken;
            return this.userResource
                .register(acessToken)
                .then(token => this.jwtCliente.setToken(token));
          });
  }

  logout(){
      return this.jwtCliente.revokeToken()
          .then(()=>{
            this._user = null;
              this._userSubject.next(this._user);
          })
  }


}
