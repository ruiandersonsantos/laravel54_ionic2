import { Injectable } from '@angular/core';
import {BrowserXhr, Request,Response, ResponseOptions, XHRBackend, XHRConnection, XSRFStrategy} from '@angular/http';
import 'rxjs/add/operator/map';
import 'rxjs/add/observable/throw';
import 'rxjs/add/operator/catch';
import {Observable} from "rxjs/Observable";
import {appContainer} from "../app/app.container";
import {JwtClient} from "./jwt-client";
import {Redirector} from "./redirector";

/*
  Generated class for the DefaultXhrBackend provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class DefaultXHRBackend extends XHRBackend{


  constructor(browserXHR: BrowserXhr,
              baseResponseOptions: ResponseOptions,
              xsrfStrategy: XSRFStrategy) {

    super(browserXHR, baseResponseOptions, xsrfStrategy);
  }


  createConnection(request: Request): XHRConnection {
    let xhrConnerction = super.createConnection(request);

      xhrConnerction.response = xhrConnerction
          .response
          .map((response) =>{

            this.tokenSetter(response);
              return response;
          })
          .catch(responseError => {
             this.unauthenticated(responseError);
              return Observable.throw(responseError);
          });

      return xhrConnerction;
  }

  tokenSetter(response: Response){
      let jwtClient = appContainer().get(JwtClient);
      if(response.headers.has('Authorization')){
          let authorization = response.headers.get('Authorization');
          let token = authorization.replace('Bearer ','');
          jwtClient.setToken(token);
      }
  }

  unauthenticated(responseError: Response){
      let redirector = appContainer().get(Redirector);
      if(responseError.status === 401){
          redirector.redirector();
      }
  }
}
