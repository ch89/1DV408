package {
	import flash.display.*;
	import flash.events.*;
	
	public class Easing extends Sprite {
		public var ball:Ball;
		public var easing:Number = .2;
		public var balls:Array;
		
		public function Easing() {
			balls = new Array();
			
			for(var i:int = 0; i < 10; i++) {
				ball = new Ball();
				ball.x = stage.stageWidth / 2;
				ball.y = stage.stageHeight / 2;
				addChild(ball);
				balls.push(ball);
			}

			addEventListener(Event.ENTER_FRAME, onEnterFrame);
		}
		
		private function onEnterFrame(e:Event):void {
			balls[0].x += (mouseX - balls[0].x) * easing;
			balls[0].y += (mouseY - balls[0].y) * easing;
			
			for(var i:int = 1; i < balls.length; i++) {
				balls[i].x += (balls[i - 1].x - balls[i].x) * easing;
				balls[i].y += (balls[i - 1].y - balls[i].y) * easing;
			}
		}
	}
}