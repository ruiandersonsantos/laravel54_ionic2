import { Injectable } from '@angular/core';
import 'rxjs/add/operator/map';
import {JwtClient} from "./jwt-client";
import {JwtPayload} from "../models/jwt-payload";
import 'rxjs/add/operator/toPromise';

/*
  Generated class for the Auth provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class Auth {

  private _user = null;

  constructor(public jwtCliente: JwtClient) {
   this.user().then((user) =>{
       console.log(user);
   })
  }

  user():Promise<Object>{

    return new Promise((resolve)=>{

        if(this._user){
        resolve(this._user);
      }

      this.jwtCliente.getPayload().then((payload:JwtPayload) =>{

        if(payload){
            this._user = payload.user;
            resolve(this._user);
        }

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

  logout(){
      return this.jwtCliente.revokeToken()
          .then(()=>{
            this._user = null;
          })
  }


}
